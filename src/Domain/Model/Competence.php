<?php

namespace App\Domain\Model;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\BaseCompetence;
use App\Domain\Logic\Competences\SubCompetenceEnum;
use App\Infrastructure\Doctrine\Repository\CompetenceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompetenceRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
    ]
)]
#[ApiFilter(BooleanFilter::class, properties: ['isBaseCompetence'])]
class Competence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups('personnage:read')]
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

    public function getFirstCharac(): SubCompetenceEnum
    {
        return $this->isBaseCompetence ? SubCompetenceEnum::from($this->firstCharac) : null;
    }

    public function setFirstCharac(SubCompetenceEnum $firstCharac): static
    {
        $this->firstCharac = $firstCharac->value;

        return $this;
    }

    public function getSecondCharac(): SubCompetenceEnum
    {
        return $this->isBaseCompetence ? SubCompetenceEnum::from($this->secondCharac) : null;
    }

    public function setSecondCharac(SubCompetenceEnum $secondCharac): static
    {
        $this->secondCharac = $secondCharac->value;

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
