<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private string $name = "";

    #[ORM\Column(length: 32)]
    private string $surname = "";

    #[ORM\Column(length: 32)]
    private string $email = "";

    #[ORM\Column(length: 255)]
    private string $password = "";


    /**
     * Set the value of id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }


    /**
     * Get the value of id
     */

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * Get the value of surname
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * Set the value of surname
     */
    public function setSurname($surname): void
    {
        $this->surname = $surname;
    }
}
