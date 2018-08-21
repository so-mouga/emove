<?php
/**
 * @author Kevin Mougammadaly <kevin.mougammadaly@ekino.com>
 */

namespace App\Controller\Api\TokenRequired;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use App\Form\CredentialsType;
use App\Entity\AuthToken;
use App\Entity\Credentials;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Operation;


class AuthTokenController extends Controller
{
    /**
     * @var EntityManager
     */
    private $doctrine;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct
    (
        EntityManagerInterface $doctrine,
        UserPasswordEncoderInterface $encoder
    )
    {
        $this->doctrine = $doctrine;
        $this->encoder = $encoder;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/auth-tokens/{id}")
     *
     * @Operation(
     *     summary="Delete token",
     *     tags={"Auth"},
     *     @SWG\Parameter(
     *          name="id",
     *          description="The token number of the user",
     *          in="path",
     *          required=true, type="string"
     *     ),
     *     @SWG\Response(
     *          response=204,
     *          description="Delete ok",
     *     ),
     * )
     */
    public function removeAuthTokenAction(Request $request)
    {
        $em = $this->doctrine;
        $authToken = $em->getRepository(AuthToken::class)
            ->find($request->get('id'));
        /* @var $authToken AuthToken */

        $connectedUser = $this->get('security.token_storage')->getToken()->getUser();

        if ($authToken && $authToken->getUser()->getId() === $connectedUser->getId()) {
            $em->remove($authToken);
            $em->flush();
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException();
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/auth-tokens")
     *
     * @Operation(
     *     summary="Connexion to get token",
     *     tags={"Auth"},
     *     @SWG\Parameter(
     *          name="login",
     *          in="query",
     *          required=true,
     *          type="string",
     *      ),
     *     @SWG\Parameter(
     *          name="password",
     *          in="query",
     *          required=true,
     *          type="string",
     *      ),
     *     @SWG\Response(
     *          response=200,
     *          description="Return an user",
     *          @SWG\Schema(
     *              @SWG\Property(property="id", type="integer"),
     *              @SWG\Property(property="value", type="string",  example="token"),
     *              @SWG\Property(property="created_at", type="string", example="13/06/2018"),
     *              @SWG\Property(property="user", ref=@Model(type=User::class, groups={User::API_GET})),
     *          )
     *      ),
     *      @SWG\Response(
     *          response=404,
     *          description="User not found with your parameters",
     *      ),
     *
     *      @SWG\Response(
     *          response=400,
     *          description="Parameter not allowed",
     *      ),
     * )
     *
     */
    public function postAuthTokensAction(Request $request)
    {
        $credentials = new Credentials();
        $form = $this->createForm(CredentialsType::class, $credentials);

        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return $form;
        }

        $em = $this->doctrine;

        $user = $em->getRepository(User::class)
            ->findOneByEmail($credentials->getLogin());

        if (!$user) { // L'utilisateur n'existe pas
            return $this->invalidCredentials();
        }

        $encoder = $this->encoder;
        $isPasswordValid = $encoder->isPasswordValid($user, $credentials->getPassword());

        if (!$isPasswordValid) { // Le mot de passe n'est pas correct
            return $this->invalidCredentials();
        }

        $authToken = new AuthToken();
        $authToken->setValue(base64_encode(random_bytes(50)));
        $authToken->setCreatedAt(new \DateTime('now'));
        $authToken->setUser($user);

        $em->persist($authToken);
        $em->flush();

        return $authToken;
    }

    private function invalidCredentials()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Invalid credentials'], Response::HTTP_BAD_REQUEST);
    }

}
