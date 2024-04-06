<?php

namespace App\Entity;

use App\Repository\MainNoteRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MainNoteRepository::class)]
class MainNote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private string $title = "";

    #[ORM\OneToMany(targetEntity: SubNote::class, mappedBy: 'sub_note')]
    private Collection $subNotes;

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
     * Get the value of subNotes
     */ 
    public function getSubNotes(): Collection
    {
        return $this->subNotes;
    }

    /**
     * Set the value of subNotes
     *
     * @return  self
     */ 
    public function setSubNotes(Collection $subNotes): void
    {
        $this->subNotes = $subNotes;
    }
}
