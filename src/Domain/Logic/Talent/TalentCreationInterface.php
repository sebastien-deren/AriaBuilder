<?php

declare(strict_types=1);

namespace App\Domain\Logic\Talent;

use App\Domain\Model\Talent;

interface TalentCreationInterface
{

    //might use a DTO we just try to make it work
    public function create(Talent $talent): Talent;
}
