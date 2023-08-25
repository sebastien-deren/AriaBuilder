<?php

namespace App\Domain\Model;

use App\Repository\CompetencePersonnageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompetencePersonnageRepository::class)]
class CompetencePersonnage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $pourcentage = null;

    #[ORM\ManyToOne(inversedBy: 'competence')]
    private ?Personnage $personage = null;

    #[ORM\ManyToOne]
    private ?Competence $competence = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPourcentage(): ?int
    {
        return $this->pourcentage;
    }

    public function setPourcentage(int $pourcentage): static
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }

    public function getPersonage(): ?Personnage
    {
        return $this->personage;
    }

    public function setPersonage(?Personnage $personage): static
    {
        $this->personage = $personage;

        return $this;
    }

    public function getCompetence(): ?Competence
    {
        return $this->competence;
    }

    public function setCompetence(?Competence $competence): static
    {
        $this->competence = $competence;

        return $this;
    }
}
