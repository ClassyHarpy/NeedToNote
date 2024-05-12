<?php

namespace App\Controller;

use App\Entity\MainNote;
use App\Entity\SubNote;
use App\Entity\User;
use App\Service\GuardService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
        return $this->guardService->Guard(function (User $user) {
            return $this->render('page/app/calendar.html.twig', ["routeName" => "Calendar", "user" => $user]);
        }, $request);
    }

    #[Route('/calendar/save', name: 'app.calendar.save', methods: ["POST"])]
    public function calendar_save(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        return $this->guardService->Guard(function (User $user) use ($request, $entityManagerInterface) {
            $event = json_decode($request->getContent(), true);

            if (isset($event["event"])) {
                $user->getCalendar()->appenData($event["event"]);

                $entityManagerInterface->persist($user->getCalendar());
                $entityManagerInterface->flush();

                return new Response();
            }

            $this->addFlash("warning", "An error occurred, please try again");
            return $this->redirect($this->generateUrl("app.calendar"));
        }, $request);
    }

    #[Route('/notes/add', name: 'app.notes.add', methods: ["GET"])]
    public function addNotePage(Request $request,): Response
    {
        return $this->guardService->Guard(function ($user) {
            return $this->render('page/app/notes/add-note.html.twig', ["routeName" => "Notes", "user" => $user]);
        }, $request);
    }

    #[Route('/note/{id}', name: 'app.note')]
    public function notePage(Request $request, EntityManagerInterface  $entityManagerInterface, int $id): Response|RedirectResponse
    {
        return $this->guardService->Guard(function ($user) use ($id, $entityManagerInterface) {
            $repository = $entityManagerInterface->getRepository(SubNote::class);
            $sub_note = $repository->findOneBy(["id" => $id]);

            if ($sub_note) {
                return $this->render('page/app/notes/note.html.twig', ["routeName" => "Note", "user" => $user, "subNote" => $sub_note]);
            }

            $this->addFlash("warning", "An error occurred, please try again");
            return $this->redirect($this->generateUrl("app"));
        }, $request);
    }

    #[Route('/note/{id}/save', name: 'app.note.save', methods: ["POST"])]
    public function noteSave(Request $request, EntityManagerInterface  $entityManagerInterface, int $id): Response|RedirectResponse
    {
        return $this->guardService->Guard(function () use ($id, $entityManagerInterface, $request) {
            $repository = $entityManagerInterface->getRepository(SubNote::class);
            $sub_note = $repository->findOneBy(["id" => $id]);
            $html = $request->getPayload()->get("html");

            if ($sub_note && strlen($html)) {
                $sub_note->setHtml(htmlspecialchars($html));

                $entityManagerInterface->persist($sub_note);
                $entityManagerInterface->flush();

                return new Response();
            }

            $this->addFlash("warning", "An error occurred, please try again");
            return $this->redirect($this->generateUrl("app.note", ["id" => $id]));
        }, $request);
    }

    #[Route('/note/{id}/delete', name: 'app.note.delete')]
    public function deleteNote(Request $request, EntityManagerInterface  $entityManagerInterface, int $id): Response
    {
        return $this->guardService->Guard(function () use ($id, $entityManagerInterface) {
            $repository = $entityManagerInterface->getRepository(SubNote::class);
            $sub_note = $repository->findOneBy(["id" => $id]);

            if ($sub_note) {
                $entityManagerInterface->remove($sub_note);
                $entityManagerInterface->flush();

                $this->addFlash("success", "Note deleted successfully!");
            } else {
                $this->addFlash("success", "Something went wrong while trying to delete the note...");
            }

            return $this->redirect($this->generateUrl("app"));
        }, $request);
    }

    #[Route('/mainNote/{id}/delete', name: 'app.mainNote.delete')]
    public function deleteMainNote(Request $request, EntityManagerInterface  $entityManagerInterface, int $id): Response
    {
        return $this->guardService->Guard(function () use ($id, $entityManagerInterface) {
            $repository = $entityManagerInterface->getRepository(MainNote::class);
            $main_note = $repository->findOneBy(["id" => $id]);

            if ($main_note) {
                $sql = "DELETE FROM sub_note WHERE main_note_id = $id";

                $conn = $entityManagerInterface->getConnection();
                $stmt = $conn->prepare($sql);
                $stmt->executeQuery();

                $entityManagerInterface->remove($main_note);
                $entityManagerInterface->flush();
        
                $this->addFlash("success", "Notebook deleted successfully!");
            } else {
                $this->addFlash("success", "Something went wrong while trying to delete the notebook...");
            }

            return $this->redirect($this->generateUrl("app"));
        }, $request);
    }

    #[Route('/notes/add', name: 'app.notes.add-submit', methods: ["POST"])]
    public function addNote(Request $request, EntityManagerInterface $entityManagerInterface): RedirectResponse
    {
        return $this->guardService->Guard(function () use ($request, $entityManagerInterface) {
            $payload = $request->getPayload();
            $title = $payload->get("title");
            $main_note_id = $payload->get("select-search-id");
            $repository = $entityManagerInterface->getRepository(MainNote::class);

            if ($title && $main_note_id && $main_note = $repository->findOneBy(["id" => $main_note_id])) {
                $main_note = $repository->findOneBy(["id" => $main_note_id]);

                $note = new SubNote();
                $note->setTitle($title);
                $note->setMainNote($main_note);

                $entityManagerInterface->persist($note);
                $entityManagerInterface->flush();

                $this->addFlash("success", "Note created successfully!");

                return $this->redirect($this->generateUrl("app.note", ["id" => $note->getId()]));
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
