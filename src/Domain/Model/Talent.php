<?php

declare(strict_types=1);

namespace App\Domain\Model;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Domain\Model\CompetencePersonnage;
use App\Domain\Model\Personnage;
use App\Domain\Logic\CompetencePersonnage\UpgradeCompetenceEnum;
use App\Repository\TalentRepository;
use App\State\TalentPostProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraint as Assert;

#[ORM\Entity(repositoryClass: TalentRepository::class)]
#[ApiResource(
    operations: [
        new Post(
            normalizationContext: ['talent:write'],
            processor: TalentPostProcessor::class
        )
    ]

)]
class Talent
{

    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column()]
    private int $id;

    #[ORM\Column]
    private int $bonus;

    #[ORM\Column]
    private int $numberOfTalent;

    #[Groups(['talent:write'])]
    #[ORM\OneToOne(targetEntity: Personnage::class)]
    private Personnage $personnage;

    #[Groups(['talent:write'])]
    #[ORM\ManyToMany(targetEntity: CompetencePersonnage::class)]
    private Collection $upgradedCompetence;

    public function __construct()
    {
        $this->upgradedCompetence = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getBonus(): UpgradeCompetenceEnum
    {
        return UpgradeCompetenceEnum::from($this->bonus);
    }

    public function setBonus(UpgradeCompetenceEnum $bonus): self
    {
        $this->bonus = $bonus->value;

        return $this;
    }

    public function getNumberOfTalent(): int
    {
        return $this->numberOfTalent;
    }

    public function setNumberOfTalent(int $numberOfTalent): self
    {
        $this->numberOfTalent = $numberOfTalent;

        return $this;
    }

    public function getUpgradedCompetence(): Collection
    {
        return $this->upgradedCompetence;
    }

    public function addUpgradedCompetence(CompetencePersonnage $upgradedCompetence): self
    {
        if (!$this->upgradedCompetence->contains($upgradedCompetence)) {
            $this->upgradedCompetence->add($upgradedCompetence);
        }
        return $this;
    }
    public function removeUpgradedCompetence(CompetencePersonnage $upgradedCompetence): self
    {
        if ($this->upgradedCompetence->removeElement($upgradedCompetence)) {
        }

        return $this;
    }

    public function getPersonnage(): Personnage
    {
        return $this->personnage;
    }

    public function setPersonnage(Personnage $personnage): self
    {
        $this->personnage = $personnage;

        return $this;
    }
}
