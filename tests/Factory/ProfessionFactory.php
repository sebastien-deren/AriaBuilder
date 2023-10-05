<?php

namespace App\Tests\Factory;

use Zenstruck\Foundry\Proxy;
use App\Domain\Model\Competence;
use App\Domain\Model\Profession;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\RepositoryProxy;
use App\Repository\ProfessionRepository;

/**
 * @extends ModelFactory<Profession>
 *
 * @method        Profession|Proxy                     create(array|callable $attributes = [])
 * @method static Profession|Proxy                     createOne(array $attributes = [])
 * @method static Profession|Proxy                     find(object|array|mixed $criteria)
 * @method static Profession|Proxy                     findOrCreate(array $attributes)
 * @method static Profession|Proxy                     first(string $sortedField = 'id')
 * @method static Profession|Proxy                     last(string $sortedField = 'id')
 * @method static Profession|Proxy                     random(array $attributes = [])
 * @method static Profession|Proxy                     randomOrCreate(array $attributes = [])
 * @method static ProfessionRepository|RepositoryProxy repository()
 * @method static Profession[]|Proxy[]                 all()
 * @method static Profession[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Profession[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Profession[]|Proxy[]                 findBy(array $attributes)
 * @method static Profession[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Profession[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class ProfessionFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'nom' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Profession $profession): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Profession::class;
    }
    public function skilled(): self
    {
        return $this->addState(["competenceProfessions" => CompetenceFactory::findOrCreate(["nom" => "nom"])]);
    }
}
