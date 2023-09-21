<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\Encoder\JsonEncode;

#[AsController]
class BaseCompetence extends AbstractController
{
    public function __construct(private CompetenceRepository $repository)
    {
    }
    public function __invoke()
    {
        return $this->repository->findByIsBaseCompetence(true);
    }
}
