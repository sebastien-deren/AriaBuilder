<?php

namespace App\Domain\Model;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BackgroundRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BackgroundRepository::class)]
#[ApiResource]
class Background
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    private ?Competence $competenceBonus = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    private ?Competence $competenceMalus = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCompetenceBonus(): ?Competence
    {
        return $this->competenceBonus;
    }

    public function setCompetenceBonus(Competence $competenceBonus): static
    {
        $this->competenceBonus = $competenceBonus;

        return $this;
    }

    public function getCompetenceMalus(): ?Competence
    {
        return $this->competenceMalus;
    }

    public function setCompetenceMalus(Competence $competenceMalus): static
    {
        $this->competenceMalus = $competenceMalus;

        return $this;
    }
}
