<?php

namespace App\Controller;

use App\Entity\MainNote;
use App\Service\GuardService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    public function addNotePage(Request $request): Response
    {
        return $this->guardService->Guard(function () {
            return $this->render('page/app/notes/add-note.html.twig', ["routeName" => "Notes"]);
        }, $request);
    }

    #[Route('/notes/add', name: 'app.notes.add-submit', methods: ["POST"])]
    public function addNote(Request $request, EntityManagerInterface  $entityManagerInterface): Response
    {
        return $this->guardService->Guard(function () use ($request, $entityManagerInterface) {
            $payload = $request->getPayload();


            return $this->redirect($this->generateUrl("app.notes.add"));
        }, $request);
    }


    #[Route('/notes/add-main', name: 'app.notes.add-main', methods: ["POST"])]
    public function addMainNote(EntityManagerInterface  $entityManagerInterface, Request $request): JsonResponse
    {
        return $this->guardService->Guard(function () use ($entityManagerInterface, $request) {
            $title = $request->getPayload()->get("title");

            if ($title) {
                $mainNote = new MainNote();
                $mainNote->setTitle($title);

                $entityManagerInterface->persist($mainNote);
                $entityManagerInterface->flush();

                return new JsonResponse(["response" => "Successfully created!", "id" => $mainNote->getId()]);
            }

            return new JsonResponse(["response" => "Invalid title!"], 400);
        }, $request);
    }
}
