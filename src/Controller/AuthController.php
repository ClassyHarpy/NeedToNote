<?php 

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AuthController extends AbstractController
{
    #[Route('/login', name: 'auth.login')]
    public function app(): Response
    {
        return $this->render('page/auth/login.html.twig');
    }

    #[Route('/register', name: 'auth.register')]
    public function calendar(): Response
    {
        return $this->render('page/auth/register.html.twig');
    }
}