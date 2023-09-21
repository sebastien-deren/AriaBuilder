<?php

declare(strict_types=1);

namespace App\PersonnageCreator\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\PersonnageCreator\Domain\Model\Profession;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\PersonnageCreator\Infrastructure\ApiPlatform\State\Profession\Provider\ProfessionItemProvider;
use App\PersonnageCreator\Infrastructure\ApiPlatform\State\Profession\Provider\ProfessionCollectionProvider;

#[ApiResource(
    shortName: "professions",
    operations: [
        new Get(
            provider: ProfessionItemProvider::class
        ),
        /* new Post(
            processor: CreateProfessionProcessor::class
        ),
        new Patch(
            provider: ProfessionItemProvider::class,
            processor: ProfessionUpdaterProcessor::class
        ),*/
        new GetCollection(
            provider: ProfessionCollectionProvider::class
        )

    ]

)]
final class ProfessionResource
{
    public function __construct(
        #[ApiProperty(identifier: true, readable: true, writable: false)]
        public ?int $id,

        #[Assert\NotNull(groups: ['create'])]
        #[Assert\Length(min: 1, max: 255, groups: ['create', 'default'])]
        public ?string $name = null,

        //IRI of Competences
        /**
         * @var <int, string> $competenceProfession
         */
        #[Assert\NotBlank(groups: ['create'])]
        public ?iterable $competenceProfession = [],
    ) {
    }

    public static function fromModel(Profession $profession)
    {
        return new self(
            $profession->getId(),
            $profession->getNom(),
            $profession->getCompetenceProfessions()
        );
    }
}
