<?php

namespace App\Entity;

use App\Repository\EquipementRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: EquipementRepository::class)]
class Equipement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    private $researchers;
    public function __construct()
    {
        $this->researchers = new ArrayCollection();
    }

    public function getResearchers(): Collection
    {
        return $this->researchers;
    }

    public function setResearchers(array $researchers): static
    {
        $this->researchers = $researchers;

        return $this;
    }

    private $projects;
    public function __construct_projects()
    {
        $this->projects = new ArrayCollection();
    }

    #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: 'equipements')]
    public function getProjects(): array
    {
        return $this->projects;
    }

    public function setProjects(array $projects): static
    {
        $this->projects = $projects;

        return $this;
    }

    private $publications;
    public function __construct_publications()
    {
        $this->publications = new ArrayCollection();
    }

    #[ORM\ManyToMany(targetEntity: Publication::class, mappedBy: 'equipements')]
    public function getPublications(): Collection
    {
        return $this->publications;
    }

    public function setpublications(Collection $publications): static
    {
        $this->status = $publications;

        return $this;
    }
}
