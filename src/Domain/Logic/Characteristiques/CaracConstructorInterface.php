<?php

declare(strict_types=1);

namespace App\Domain\Logic\Characteristiques;

use App\Domain\Logic\Characteristiques\DTO\AbstractSkillInput;
use App\Domain\Model\Caracteristique;

interface CaracConstructorInterface
{
    public function create(AbstractSkillInput $skillInput):Caracteristique;
}
