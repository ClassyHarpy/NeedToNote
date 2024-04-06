<?php

namespace App\Controller;

use App\Service\GuardService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AppController extends AbstractController
{
    public function __construct(private readonly GuardService $guardService)
    {
    }

    #[Route('/', name: 'app')]
    public function app(Request $request): Response
    {
        return $this->guardService->Guard(function () {
            return $this->render('page/index.html.twig', ["routeName" => ""]);
        }, $request);
    }

    #[Route('/calendar', name: 'app.calendar')]
    public function calendar(Request $request): Response
    {
        return $this->guardService->Guard(function () {
            return $this->render('page/app/calendar.html.twig', ["routeName" => "Calendar"]);
        }, $request);
    }

    #[Route('/notes/add', name: 'app.notes.add')]
    public function addNote(Request $request): Response
    {
        return $this->guardService->Guard(function () {
            return $this->render('page/app/notes/add-note.html.twig', ["routeName" => "Notes"]);
        }, $request);
    }
}
