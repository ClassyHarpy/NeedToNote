<?php

namespace App\Service;

use Closure;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class GuardService {
    function Guard(Closure $closure, Request $request): Response|RedirectResponse
    {
        if ($request->getSession()->get($_ENV["SESSION_COOKIE"])) {
            return $closure();
        } else {
            return new RedirectResponse("/login");
        }
    }
    
}
