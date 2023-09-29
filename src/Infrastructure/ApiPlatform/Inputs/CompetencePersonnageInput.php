<?php

declare(strict_types=1);

namespace App\Infrastructure\ApiPlatform\Inputs;

class CompetencePersonnageInput
{
    public function __construct(
        public string $competence,
        public string $personnage
    ) {
    }
}
