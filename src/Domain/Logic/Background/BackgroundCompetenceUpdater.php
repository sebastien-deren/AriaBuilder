<?php

declare(strict_types=1);

namespace App\Domain\Logic\Background;

use App\Domain\Logic\CompetencePersonnage\CompetencePersonnageUpdaterInterface;
use App\Domain\Logic\CompetencePersonnage\UpgradeCompetenceEnum;
use App\Domain\Model\Background;

class BackgroundCompetenceUpdater implements BackgroundCompetenceUpdaterInterface
{
    public function __construct(private CompetencePersonnageUpdaterInterface $comPersoUpdater)
    {
    }
    public function updateCompetenceFromBackground(Background $background): Background
    {
        $this->comPersoUpdater->updateCompetence($background->getCompetenceBonus(), UpgradeCompetenceEnum::Bonus);
        $this->comPersoUpdater->updateCompetence($background->getCompetenceMalus(), UpgradeCompetenceEnum::Malus);

        return $background;
    }
}
