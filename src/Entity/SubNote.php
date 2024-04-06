<?php

namespace App\Entity;

use App\Repository\SubNoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubNoteRepository::class)]
class SubNote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private string $title = "";

    #[ORM\ManyToOne(targetEntity: MainNote::class, inversedBy: 'main_note')]
    private MainNote $mainNote;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * Get the value of mainNote
     */ 
    public function getMainNote(): MainNote
    {
        return $this->mainNote;
    }

    /**
     * Set the value of mainNote
     *
     * @return  self
     */ 
    public function setMainNote(MainNote $mainNote): void
    {
        $this->mainNote = $mainNote;
    }
}
