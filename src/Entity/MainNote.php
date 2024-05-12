<?php

namespace App\Entity;

use App\Repository\MainNoteRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MainNoteRepository::class)]
#[ORM\Table(name: 'main_note')]
class MainNote
{
    public function __construct()
    {
        $this->subNotes = new ArrayCollection();
    }
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    #[Assert\NotBlank]
    private string $title = "";

    #[ORM\OneToMany(targetEntity: SubNote::class, mappedBy: 'mainNote')]
    private Collection $subNotes;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $user;

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
     * @return Collection<int, SubNote>
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
    public function setSubNotes(ArrayCollection $subNotes): void
    {
        $this->subNotes = $subNotes;
    }

    /**
     * Get the value of user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}
