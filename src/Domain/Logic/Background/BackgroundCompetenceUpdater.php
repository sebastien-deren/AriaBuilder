<?php

declare(strict_types=1);

namespace App\Domain\Logic\Background;

use App\Domain\Logic\CompetencePersonnage\CompetencePersonnageUpdaterInterface;
use App\Domain\Logic\CompetencePersonnage\UpgradeCompetenceEnum;
use App\Domain\Model\Background;

class BackgroundCompetenceUpdater implements BackgroundCompetenceUpdaterInterface
{
    public function __construct(private CompetencePersonnageUpdaterInterface $competencePersonnageUpdater)
    {
    }
    public function updateCompetenceFromBackground(Background $background): Background
    {
        $this->comPersoUpdater->updateCompetencePercentage($background->getCompetenceBonus(), $background->getPersonnage(), UpgradeCompetenceEnum::Bonus);
        $this->comPersoUpdater->updateCompetencePercentage($background->getCompetenceMalus(), $background->getPersonnage(), UpgradeCompetenceEnum::Malus);

        return $background;
    }
}
