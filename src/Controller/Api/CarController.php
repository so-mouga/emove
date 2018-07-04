<?php
/**
 * Created by PhpStorm.
 * User: kevinmouga
 * Date: 04/07/2018
 * Time: 09:43
 */
namespace App\Controller\Api;

use FOS\RestBundle\FOSRestBundle;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class CarController extends FOSRestBundle
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Rest\Get("/cars")
     * @Rest\View()
     */
    public function getList(Request $request)
    {
        $users = $this->userRepository->findAll();

        return $users;
    }
}
