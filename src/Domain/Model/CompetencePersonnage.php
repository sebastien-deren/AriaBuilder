<?php

namespace App\Domain\Model;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Metadata\ApiFilter;
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
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompetencePersonnageRepository::class)]
#[ApiResource(
    operations: [
        new Post(uriTemplate: 'base_competence/auto.{_format}', input: CompetencePersonnageInput::class, processor: PostProcessorBaseCompetence::class),
        new Get(
            uriTemplate: 'competence_personnages/{id}.{_format}',
            //output: CompetencePersonnageOutput::class, provider: GetProviderCompetencePersonnage::class
        ),
        new GetCollection(
            uriTemplate: 'personnage/{id_perso}/competences.{_format}',
            uriVariables: [
                'id_perso' => new Link(
                    fromProperty: 'competence',
                    fromClass: Personnage::class,
                )
            ],
            //output: CompetencePersonnagesCollectionOutput::class,
            //provider: GetCollectionProviderCompetencePersonnage::class
        )
    ]
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
    private ?Personnage $personnage = null;

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

    public function getpersonnage(): ?Personnage
    {
        return $this->personnage;
    }

    public function setpersonnage(?Personnage $personnage): static
    {
        $this->personnage = $personnage;

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
