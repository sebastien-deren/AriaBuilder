<?php

namespace App\Domain\Model;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\CompetenceRepository;

#[ORM\Entity(repositoryClass: CompetenceRepository::class)]
#[ApiResource]
class Competence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstCharac = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $secondCharac = null;

    #[ORM\Column]
    private ?bool $isBaseCompetence = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getFirstCharac(): ?string
    {
        return $this->firstCharac;
    }

    public function setFirstCharac(string $firstCharac): static
    {
        $this->firstCharac = $firstCharac;

        return $this;
    }

    public function getSecondCharac(): ?string
    {
        return $this->secondCharac;
    }

    public function setSecondCharac(string $secondCharac): static
    {
        $this->secondCharac = $secondCharac;

        return $this;
    }

    public function isIsBaseCompetence(): ?bool
    {
        return $this->isBaseCompetence;
    }

    public function setIsBaseCompetence(bool $isBaseCompetence): static
    {
        $this->isBaseCompetence = $isBaseCompetence;

        return $this;
    }
}
