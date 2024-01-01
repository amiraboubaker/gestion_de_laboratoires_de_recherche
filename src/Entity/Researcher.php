<?php

namespace App\Entity;

use App\Repository\ResearcherRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResearcherRepository::class)]
class Researcher
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $roles = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    #[ORM\ManyToOne(targetEntity: Project::class, mappedBy: 'publications')]
    public function getProjects(): array
    {
        return $this->projects;
    }

    public function setProjects(array $projects): static
    {
        $this->projects = $projects;

        return $this;
    }

    #[ORM\OneToMany(targetEntity: Publication::class, mappedBy: 'researcher')]
    public function getpublications(): ?string
    {
        return $this->$publications;
    }

    public function setpublications(string $publications): static
    {
        $this->status = $publications;

        return $this;
    }
}
