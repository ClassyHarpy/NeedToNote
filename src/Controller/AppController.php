<?php 

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AppController extends AbstractController
{
    #[Route('/', name: 'app')]
    public function app(): Response
    {
        return $this->render('page/index.html.twig', ["routeName" => ""]);
    }

    #[Route('/calendar', name: 'app.calendar')]
    public function calendar(): Response
    {
        return $this->render('page/app/calendar.html.twig', ["routeName" => "Calendar"]);
    }
}