<?php

namespace App\Domain\Model;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use App\Domain\Model\Profession;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\Domain\Model\Caracteristique;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\PersonnageRepository;
use App\State\PersonnageUpdaterProcessor;
use App\Domain\Model\CompetencePersonnage;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PersonnageRepository::class)]
#[ApiResource(
    shortName: 'Personnage',
    description: 'Personnage Jouable dans l\'univer d\'aria',
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Patch(
            processor: PersonnageUpdaterProcessor::class
        ),
    ],
    paginationItemsPerPage: 10,
    denormalizationContext: [
        'groups' => ['personnage:write'],
    ],
    normalizationContext: [
        'groups' => ['personnage:read'],
    ]
)]
class Personnage
{
    #[Groups(['personnage:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['personnage:write', 'personnage:read'])]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[Groups(['personnage:write', 'personnage:read'])]
    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[Groups(['personnage:write', 'personnage:read'])]
    #[ORM\Column(length: 255)]
    private ?string $age = null;

    #[Groups(['personnage:write', 'personnage:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $genie = null;

    #[Groups(['personnage:write', 'personnage:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $societe = null;

    #[Groups(['personnage:write', 'personnage:read'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[Groups(['personnage:read'])]
    #[ORM\OneToOne(inversedBy: 'personnage', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private ?Caracteristique $caracteristique = null;

    #[Groups(['personnage:read'])]
    #[ORM\OneToMany(mappedBy: 'personage', targetEntity: CompetencePersonnage::class, cascade: ['persist', 'remove'])]
    private ?Collection $competence = null;

    #[Groups()]
    #[ORM\ManyToMany(targetEntity: Background::class)]
    private ?Collection $background;
    #[Groups(['personnage:profession', 'personnage:read', 'personnage:write'])]
    #[ORM\ManyToOne(targetEntity: Profession::class)]
    private ?Profession $profession = null;

    public function __construct()
    {
        $this->competence = new ArrayCollection();
        $this->background = new ArrayCollection();
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
    public function addBackground(Background $background): static
    {
        if (!$this->background->contains($background)) {
            $this->background->add($background);
        }
        return $this;
    }


    public function removeBackground($background): static
    {
        $this->background->removeElement($background);
        return $this;
    }

    public function getBackground(): Collection
    {
        return $this->background;
    }

    public function getProfession(): ?Profession
    {

        return $this->profession;
    }
    public function setProfession(Profession $profession): static
    {
        $this->profession = $profession;

        return $this;
    }
}
