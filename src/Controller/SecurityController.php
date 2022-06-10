<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

class SecurityController extends AbstractController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    #[Route('/login', name: 'login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return new Response($this->twig->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error
        ]));
    }

    #[Route('/login_check', name: 'login_check', methods: ['GET', 'POST'])]
    public function loginCheck(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return new Response($this->twig->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error
        ]));
    }

    #[Route('/logout', name: 'logout', methods: ['GET'])]
    public function logoutCheck()
    {
        throw new Exception('N\'oubliez pas d\'activer logout dans security.yaml.');
    }
}
