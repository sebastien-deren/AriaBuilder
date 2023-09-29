<?php

namespace App\Tests\Factory;

use App\Domain\Model\CompetencePersonnage;
use App\Repository\CompetencePersonnageRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<CompetencePersonnage>
 *
 * @method        CompetencePersonnage|Proxy                     create(array|callable $attributes = [])
 * @method static CompetencePersonnage|Proxy                     createOne(array $attributes = [])
 * @method static CompetencePersonnage|Proxy                     find(object|array|mixed $criteria)
 * @method static CompetencePersonnage|Proxy                     findOrCreate(array $attributes)
 * @method static CompetencePersonnage|Proxy                     first(string $sortedField = 'id')
 * @method static CompetencePersonnage|Proxy                     last(string $sortedField = 'id')
 * @method static CompetencePersonnage|Proxy                     random(array $attributes = [])
 * @method static CompetencePersonnage|Proxy                     randomOrCreate(array $attributes = [])
 * @method static CompetencePersonnageRepository|RepositoryProxy repository()
 * @method static CompetencePersonnage[]|Proxy[]                 all()
 * @method static CompetencePersonnage[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static CompetencePersonnage[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static CompetencePersonnage[]|Proxy[]                 findBy(array $attributes)
 * @method static CompetencePersonnage[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static CompetencePersonnage[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class CompetencePersonnageFactory extends ModelFactory
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
            'pourcentage' => self::faker()->randomNumber(2),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(CompetencePersonnage $competencePersonnage): void {})
        ;
    }

    protected static function getClass(): string
    {
        return CompetencePersonnage::class;
    }
}
