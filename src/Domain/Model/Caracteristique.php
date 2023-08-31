<?php

namespace App\Domain\Model;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CaracteristiqueRepository;

#[ORM\Entity(repositoryClass: CaracteristiqueRepository::class)]
#[ApiResource()]
class Caracteristique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $force = null;

    #[ORM\Column(nullable: true)]
    private ?int $endurance = null;

    #[ORM\Column(nullable: true)]
    private ?int $dexterite = null;

    #[ORM\Column]
    private ?int $intelligence = null;

    #[ORM\Column(nullable: true)]
    private ?int $charisme = null;

    #[ORM\Column(nullable: true)]
    private ?int $caracPoint = null;

    #[ORM\OneToOne(inversedBy: 'caracteristique', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personnage $personnage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getForce(): ?int
    {
        return $this->force;
    }

    public function setForce(?int $force): static
    {
        $this->force = $force;

        return $this;
    }

    public function getEndurance(): ?int
    {
        return $this->endurance;
    }

    public function setEndurance(?int $endurance): static
    {
        $this->endurance = $endurance;

        return $this;
    }

    public function getDexterite(): ?int
    {
        return $this->dexterite;
    }

    public function setDexterite(?int $dexterite): static
    {
        $this->dexterite = $dexterite;

        return $this;
    }

    public function getIntelligence(): ?int
    {
        return $this->intelligence;
    }

    public function setIntelligence(int $intelligence): static
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    public function getCharisme(): ?int
    {
        return $this->charisme;
    }

    public function setCharisme(?int $charisme): static
    {
        $this->charisme = $charisme;

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
        return $this->personnage;
    }

    public function setPersonnage(Personnage $personnage): static
    {
        $this->personnage = $personnage;

        return $this;
    }
}
