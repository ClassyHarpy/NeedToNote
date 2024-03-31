<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class ContextService
{

    public function __construct(private readonly EntityManagerInterface $entityManager) {

    }

    public function user(): User|null
    {
        
        return $this->entityManager->getRepository(User::class)->find(1);
    }
}
