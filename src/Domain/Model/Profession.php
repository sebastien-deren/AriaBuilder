<?php

namespace App\Domain\Model;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProfessionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfessionRepository::class)]
#[ApiResource]
class Profession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Competence $competencePremiere = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Competence $competenceSeconde = null;

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

    public function getCompetencePremiere(): ?Competence
    {
        return $this->competencePremiere;
    }

    public function setCompetencePremiere(?Competence $competencePremiere): static
    {
        $this->competencePremiere = $competencePremiere;

        return $this;
    }

    public function getCompetenceSeconde(): ?Competence
    {
        return $this->competenceSeconde;
    }

    public function setCompetenceSeconde(?Competence $competenceSeconde): static
    {
        $this->competenceSeconde = $competenceSeconde;

        return $this;
    }
}
