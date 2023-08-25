<?php

namespace App\Domain\Model;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PersonnageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonnageRepository::class)]
#[ApiResource]
class Personnage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $age = null;

    #[ORM\Column(length: 255)]
    private ?string $genie = null;

    #[ORM\Column(length: 255)]
    private ?string $societe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\OneToOne(mappedBy: 'Personnage', cascade: ['persist', 'remove'])]
    private ?Caracteristique $caracteristique = null;

    #[ORM\OneToMany(mappedBy: 'perssonage', targetEntity: CompetencePersonnage::class)]
    private Collection $competence;

    public function __construct()
    {
        $this->competence = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getGenie(): ?string
    {
        return $this->genie;
    }

    public function setGenie(string $genie): static
    {
        $this->genie = $genie;

        return $this;
    }

    public function getSociete(): ?string
    {
        return $this->societe;
    }

    public function setSociete(string $societe): static
    {
        $this->societe = $societe;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCaracteristique(): ?Caracteristique
    {
        return $this->caracteristique;
    }

    public function setCaracteristique(Caracteristique $caracteristique): static
    {
        // set the owning side of the relation if necessary
        if ($caracteristique->getPersonnage() !== $this) {
            $caracteristique->setPersonnage($this);
        }

        $this->caracteristique = $caracteristique;

        return $this;
    }

    /**
     * @return Collection<int, CompetencePersonnage>
     */
    public function getCompetence(): Collection
    {
        return $this->competence;
    }

    public function addCompetence(CompetencePersonnage $competence): static
    {
        if (!$this->competence->contains($competence)) {
            $this->competence->add($competence);
            $competence->setPersonage($this);
        }

        return $this;
    }

    public function removeCompetence(CompetencePersonnage $competence): static
    {
        if ($this->competence->removeElement($competence)) {
            // set the owning side to null (unless already changed)
            if ($competence->getPersonage() === $this) {
                $competence->setPersonage(null);
            }
        }

        return $this;
    }
}
