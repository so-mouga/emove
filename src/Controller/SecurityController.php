<?php
/**
 * @author Kevin Mougammadaly <kevin.mougammadaly@ekino.com>
 */

namespace App\Controller;


use App\Entity\Agency;
use App\Entity\Payment;
use App\Entity\Penalty;
use App\Entity\Rental;
use App\Entity\User;
use App\Entity\Vehicle;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        dump(new Agency());
        dump(new User());
        dump(new Rental());
        dump(new Vehicle());
        dump(new Payment());
        dump(new Penalty());
        exit;

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));

    }

}
