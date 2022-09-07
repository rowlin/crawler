<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\UserRepository;

#[ORM\Table(name : 'users')]
/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface , PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;


    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @ORM\Column(type="string" , unique="true")
     */
    private string $email;

    /**
     * @ORM\Column(type="string")
     */
    private string $password;


    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function setName(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        // TODO: Implement getPassword() method.
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials(): ?string
    {
        return null;
    }

    public function getUserIdentifier(): string
    {
        return  $this->email;
    }
}
