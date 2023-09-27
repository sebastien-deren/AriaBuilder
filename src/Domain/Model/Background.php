<?php

namespace App\Domain\Model;

use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Repository\BackgroundRepository;
use App\State\BackgroundPostProcessor;
use ApiPlatform\OpenApi\Model;

#[ORM\Entity(repositoryClass: BackgroundRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Post(
            openapi: new Model\Operation(
                summary: 'creer un background pour un personnage',
                description: 'créer un background pour un personnage, les competences associées viendront modifier les pourcentages de competencePersonnage'
            ),
            processor: BackgroundPostProcessor::class,
        ),
    ]
)]
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

    #[ORM\ManyToOne()]
    private ?Personnage $personnage = null;

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

    /**
     * Get the value of personnage
     */
    public function getPersonnage(): ?Personnage
    {
        return $this->personnage;
    }

    /**
     * Set the value of personnage
     *
     * @return  self
     */
    public function setPersonnage(Personnage $personnage): static
    {
        $this->personnage = $personnage;

        return $this;
    }
}
