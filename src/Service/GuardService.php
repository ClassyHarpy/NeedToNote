<?php

namespace App\Service;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;


class GuardService
{

    public function __construct(private readonly EntityManagerInterface $entityManagerInterface)
    {
    }

    function Guard(Closure $closure, Request $request): Response|RedirectResponse
    {
        if ($request->getSession()->get($_ENV["SESSION_COOKIE"])) {
      //      try {
                $user_id = $request->getSession()->get($_ENV["SESSION_COOKIE"]);
                $repository = $this->entityManagerInterface->getRepository(User::class);
                $user =  $repository->findOneBy(["id" => $user_id]);

                return $closure($user);
      //      } catch (\Throwable $_) {
        //        return new RedirectResponse("/login");
          //  }
        } else {
            return new RedirectResponse("/login");
        }
    }
}
