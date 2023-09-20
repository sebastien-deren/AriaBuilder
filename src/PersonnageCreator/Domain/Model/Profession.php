<?php

namespace App\PersonnageCreator\Domain\Model;

use App\Domain\Model\Competence;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Model\CompetenceProfession;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
class Profession
{
//App\PersonnageCreator\Infrastucture\Doctrine\Repository\DoctrineProfessionRepository
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;


    #[ORM\Column(length: 255)]
    private string $nom;


    #[ORM\ManyToMany(targetEntity: Competence::class)]
    private Collection $competenceProfessions;

    public function __construct()
    {
        $this->competenceProfessions = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
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
    public function getCompetenceProfessions(): Collection
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
