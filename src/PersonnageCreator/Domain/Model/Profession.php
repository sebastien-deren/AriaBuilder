<?php

namespace App\PersonnageCreator\Domain\Model;

use ApiPlatform\Metadata\ApiProperty;
use App\Domain\Model\Competence;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Model\CompetenceProfession;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
class Profession
{
    //App\PersonnageCreator\Infrastructure\Doctrine\Repository\DoctrineProfessionRepository

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;
    public function __construct(
        #[ApiProperty(iris:[''])]
        #[ORM\Column(length: 255)]
        private string $nom,


        /**
         * @param Collection<Competence> $competenceProfessions
         */
        #[ORM\ManyToMany(targetEntity: Competence::class)]
        private Collection $competenceProfessions,


    ) {
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
     * @return Collection<int, Competence>
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

    public function __toString()
    {
        //evidement on veut pas ça dans notre domaine on est pas des porcs mais on test si ça marche
        return 'api/professions/';
    }
}
