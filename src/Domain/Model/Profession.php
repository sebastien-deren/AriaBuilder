<?php

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProfessionRepository;
use App\Domain\Model\CompetenceProfession;
use Doctrine\Common\Collections\Collection;
use App\Domain\Collection\CollectionCompetence;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Domain\Collection\CollectionCompetenceInterface;
use ApiPlatform\Api\QueryParameterValidator\Validator\Enum;

#[ORM\Entity(repositoryClass: ProfessionRepository::class)]
#[ApiResource()]
class Profession
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('profession:read')]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Groups('profession:read')]
    private ?string $nom = null;


    #[ORM\ManyToMany(targetEntity: Competence::class)]
    #[Groups('profession:read')]
    private CollectionCompetence $competenceProfessions;

    public function __construct()
    {
        $this->competenceProfessions = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, CompetenceProfession>
     */
    public function getCompetenceProfessions(): CollectionCompetence
    {
        return $this->competenceProfessions;
    }

    public function addCompetenceProfession(Competence $competenceProfession): static
    {
        if (!$this->competenceProfessions->contains($competenceProfession)) {
            $this->competenceProfessions->add($competenceProfession);
        }

        return $this;
    }

    public function removeCompetenceProfession($competenceProfession): static
    {
        if ($this->competenceProfessions->removeElement($competenceProfession)) {
            $competenceProfession->removeProfession($this);
        }

        return $this;
    }
}
