<?php

namespace App\Domain\Model;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Infrastructure\ApiPlatform\Inputs\CompetencePersonnageInput;
use App\Infrastructure\ApiPlatform\State\PostProcessorBaseCompetence;
use App\Repository\CompetencePersonnageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompetencePersonnageRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new Post(uriTemplate: 'base_competence/auto.{_format}', input: CompetencePersonnageInput::class, processor: PostProcessorBaseCompetence::class)
    ]
)]
#[ApiResource(
    uriTemplate: 'personnages/{id_perso}/competences.{_format}',
    uriVariables: [
        'id_perso' => new Link(
            fromProperty: 'competence',
            fromClass: Personnage::class
        )
    ],
    operations: [new GetCollection(), new Post(), new Patch()]

)]
class CompetencePersonnage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups("personnage:read")]
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
