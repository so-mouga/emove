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
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Symfony\Component\HttpFoundation\Response;


class UserController extends FOSRestBundle
{
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
     *
     * @QueryParam(name="firstName")
     * @QueryParam(name="lastName", requirements="\d+")
     * @QueryParam(name="email", requirements="\d+")
     * @QueryParam(name="password", requirements="\d+")
     * @QueryParam(name="birthday", requirements="\d+")
     * @QueryParam(name="adresse", requirements="\d+")
     * @QueryParam(name="postalCode", requirements="\d+")
     * @QueryParam(name="phone", requirements="\d+")
     * @QueryParam(name="permis", requirements="\d+")
     */
    public function createUser(Request $request, ParamFetcher $paramFetcher)
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);

        if (!empty($request->get('birthday'))) {
            $user->setBirthday(new \DateTime($request->get('birthday')));
        }
        if (!empty($request->get('permis'))) {
            $user->setPermis(new \DateTime($request->get('permis')));
        }
        $form = $this->formFactory->create(UserType::class, $user);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $this->doctrine->persist($user);
            $this->doctrine->flush();
            return $user;
        } else {
            return $form;
        }
    }


}
