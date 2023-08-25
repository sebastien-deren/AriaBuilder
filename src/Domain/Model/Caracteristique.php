<?php

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CaracteristiqueRepository;

#[ORM\Entity(repositoryClass: CaracteristiqueRepository::class)]
class Caracteristique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $Force = null;

    #[ORM\Column(nullable: true)]
    private ?int $Endurance = null;

    #[ORM\Column(nullable: true)]
    private ?int $Dexterite = null;

    #[ORM\Column]
    private ?int $Intelligence = null;

    #[ORM\Column(nullable: true)]
    private ?int $Charisme = null;

    #[ORM\Column(nullable: true)]
    private ?int $caracPoint = null;

    #[ORM\OneToOne(inversedBy: 'caracteristique', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personnage $Personnage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getForce(): ?int
    {
        return $this->Force;
    }

    public function setForce(?int $Force): static
    {
        $this->Force = $Force;

        return $this;
    }

    public function getEndurance(): ?int
    {
        return $this->Endurance;
    }

    public function setEndurance(?int $Endurance): static
    {
        $this->Endurance = $Endurance;

        return $this;
    }

    public function getDexterite(): ?int
    {
        return $this->Dexterite;
    }

    public function setDexterite(?int $Dexterite): static
    {
        $this->Dexterite = $Dexterite;

        return $this;
    }

    public function getIntelligence(): ?int
    {
        return $this->Intelligence;
    }

    public function setIntelligence(int $Intelligence): static
    {
        $this->Intelligence = $Intelligence;

        return $this;
    }

    public function getCharisme(): ?int
    {
        return $this->Charisme;
    }

    public function setCharisme(?int $Charisme): static
    {
        $this->Charisme = $Charisme;

        return $this;
    }

    public function getCaracPoint(): ?int
    {
        return $this->caracPoint;
    }

    public function setCaracPoint(?int $caracPoint): static
    {
        $this->caracPoint = $caracPoint;

        return $this;
    }

    public function getPersonnage(): ?Personnage
    {
        return $this->Personnage;
    }

    public function setPersonnage(Personnage $Personnage): static
    {
        $this->Personnage = $Personnage;

        return $this;
    }
}
