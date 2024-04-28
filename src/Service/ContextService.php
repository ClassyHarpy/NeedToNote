<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\MainNote;

class ContextService
{

    public function __construct(private readonly EntityManagerInterface $entityManager) {

    }

    /**
     * @return MainNote[]
     */
    public function mainNotes(): array {
        return $this->entityManager->getRepository(MainNote::class)->findAll();
    }
}
