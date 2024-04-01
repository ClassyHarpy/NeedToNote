<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class AuthController extends AbstractController
{
    #[Route('/login', name: 'auth.login')]
    public function login(Request $request): Response
    {
        return $this->render('page/auth/login.html.twig');
    }

    #[Route('/register', name: 'auth.register')]
    public function register(): Response
    {
        return $this->render('page/auth/register.html.twig');
    }

    // Submit
    #[Route('/login_submit', name: 'auth.login.submit', methods: ["post"])]
    public function login_submit(Request $request, EntityManagerInterface  $entityManagerInterface): RedirectResponse
    {
        $payload = $request->getPayload();
        $email = $payload->get("email");
        $password = $payload->get("password");

        if ($email && $password) {
            $hash = hash("sha256", $password);
            $repository = $entityManagerInterface->getRepository(User::class);

            $user =  $repository->findOneBy(["email" => $email, "password" => $hash]);

            if ($user) {
                $this->addFlash("success", "Kevin todo message!!!!");

                $request->getSession()->set($_ENV["SESSION_COOKIE"], "test");

                return $this->redirect($this->generateUrl("app"));
            }
        }

        $this->addFlash("danger", "Kevin todo message. Wtf wrong creds");
        return $this->redirect($this->generateUrl("auth.login"));
    }

    #[Route('/register_submit', name: 'auth.register.submit', methods: ["post"])]
    public function register_submit(Request $request, EntityManagerInterface  $entityManagerInterface): RedirectResponse
    {
        $payload = $request->getPayload();
        $name = $payload->get("name");
        $surname = $payload->get("surname");
        $email = $payload->get("email");
        $password = $payload->get("password");

        if ($name && $surname && $email && $password) {
            $user = new User();
            $user->setName($name);
            $user->setSurname($surname);
            $user->setEmail($email);
            $hash = hash("sha256", $password);
            $user->setPassword($hash);

            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();

            $this->addFlash("success", "Kevin todo message!!!!");

            $request->getSession()->set($_ENV["SESSION_COOKIE"], "test");

            return $this->redirect($this->generateUrl("app"));
        } else {
            $this->addFlash("warning", "Kevin todo message");
            return $this->redirect($this->generateUrl("auth.register"));
        }
    }
}
