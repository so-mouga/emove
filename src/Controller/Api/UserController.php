<?php
/**
 * @author Kevin Mougammadaly <kevin.mougammadaly@ekino.com>
 */
namespace App\Controller\Api;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\FOSRestBundle;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\Response;


class UserController extends FOSRestBundle
{
    use ApiErrorsTrait;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var FormFactory
     */
    private $formFactory;

    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

    public function __construct(
        UserRepository $userRepository,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $doctrine
    )
    {
        $this->userRepository = $userRepository;
        $this->formFactory = $formFactory;
        $this->doctrine = $doctrine;
    }

    /**
     * @Rest\Post("/create/users")
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     *
     * @param Request $request
     */
    public function createUser(Request $request)
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);

        return $this->handleUser($user, $request);
    }

    /**
     * @param User    $user
     * @param Request $request
     * @param bool    $clearMissing
     *
     * @return User|JsonResponse
     */
    private function handleUser(User $user, Request $request, bool $clearMissing = true)
    {
        $form = $this->formFactory->create(UserType::class, $user);
        $form->submit($request->request->all(), $clearMissing);

        if (!$form->isValid()) {
            $readableErrors = $this->getFormErrors($form);

            return new JsonResponse(['message' => 'Invalid data sent', 'errors' => $readableErrors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->doctrine->persist($user);
        $this->doctrine->flush();

        return $user;
    }


}
