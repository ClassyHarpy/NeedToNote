<?php

namespace App\Controller;

use App\Entity\MainNote;
use App\Entity\SubNote;
use App\Service\GuardService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        return $this->guardService->Guard(function ($user) {
            return $this->render('page/index.html.twig', ["routeName" => "", "user" => $user]);
        }, $request);
    }

    #[Route('/calendar', name: 'app.calendar')]
    public function calendar(Request $request): Response
    {
        return $this->guardService->Guard(function ($user) {
            return $this->render('page/app/calendar.html.twig', ["routeName" => "Calendar", "user" => $user]);
        }, $request);
    }

    #[Route('/notes/add', name: 'app.notes.add')]
    public function addNotePage(Request $request): Response
    {
        return $this->guardService->Guard(function ($user) {
            return $this->render('page/app/notes/add-note.html.twig', ["routeName" => "Notes", "user" => $user]);
        }, $request);
    }

    #[Route('/notes', name: 'app.note')]
    public function notePage(Request $request): Response
    {
        return $this->guardService->Guard(function ($user) {
            return $this->render('page/app/notes/note.html.twig', ["routeName" => "Note", "user" => $user]);
        }, $request);
    }

    #[Route('/notes/add', name: 'app.notes.add-submit', methods: ["POST"])]
    public function addNote(Request $request, EntityManagerInterface  $entityManagerInterface): Response
    {
        return $this->guardService->Guard(function () use ($request, $entityManagerInterface) {
            $payload = $request->getPayload();
            $title = $payload->get("title");
            $main_note_id = $payload->get("select-search-id");

            if ($title && $main_note_id) {
                $repository = $entityManagerInterface->getRepository(MainNote::class);
                $main_note = $repository->findOneBy(["id" => $main_note_id]);

                $note = new SubNote();
                $note->setTitle($title);
                $note->setMainNote($main_note);

                $entityManagerInterface->persist($note);
                $entityManagerInterface->flush();

                $this->addFlash("success", "Note created successfully!");

                return $this->redirect($this->generateUrl("app.note"));
            }

            $this->addFlash("danger", "Something went wrong while trying to create a note...");
            return $this->redirect($this->generateUrl("app.notes.add"));
        }, $request);
    }


    #[Route('/notes/add-main', name: 'app.notes.add-main', methods: ["POST"])]
    public function addMainNote(EntityManagerInterface $entityManagerInterface, Request $request): JsonResponse
    {
        return $this->guardService->Guard(function ($user) use ($entityManagerInterface, $request) {
            $title = $request->getPayload()->get("title");

            if ($title) {
                $mainNote = new MainNote();
                $mainNote->setTitle($title);
                $mainNote->setUser($user);

                $entityManagerInterface->persist($mainNote);
                $entityManagerInterface->flush();

                return new JsonResponse(["response" => "Successfully created!", "id" => $mainNote->getId()]);
            }

            return new JsonResponse(["response" => "Invalid title!"], 400);
        }, $request);
    }
}
