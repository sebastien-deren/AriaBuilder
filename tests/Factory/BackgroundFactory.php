<?php

namespace App\Tests\Factory;

use App\Domain\Model\Background;
use App\Factory\CompetenceFactory;
use App\Repository\BackgroundRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Background>
 *
 * @method        Background|Proxy                     create(array|callable $attributes = [])
 * @method static Background|Proxy                     createOne(array $attributes = [])
 * @method static Background|Proxy                     find(object|array|mixed $criteria)
 * @method static Background|Proxy                     findOrCreate(array $attributes)
 * @method static Background|Proxy                     first(string $sortedField = 'id')
 * @method static Background|Proxy                     last(string $sortedField = 'id')
 * @method static Background|Proxy                     random(array $attributes = [])
 * @method static Background|Proxy                     randomOrCreate(array $attributes = [])
 * @method static BackgroundRepository|RepositoryProxy repository()
 * @method static Background[]|Proxy[]                 all()
 * @method static Background[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Background[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Background[]|Proxy[]                 findBy(array $attributes)
 * @method static Background[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Background[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<Background> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Background> createOne(array $attributes = [])
 * @phpstan-method static Proxy<Background> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<Background> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<Background> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<Background> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<Background> random(array $attributes = [])
 * @phpstan-method static Proxy<Background> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<Background> repository()
 * @phpstan-method static list<Proxy<Background>> all()
 * @phpstan-method static list<Proxy<Background>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<Background>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<Background>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<Background>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<Background>> randomSet(int $number, array $attributes = [])
 */
final class BackgroundFactory extends ModelFactory
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
            'competenceBonus' => CompetenceFactory::new(),
            'competenceMalus' => CompetenceFactory::new(),
            'description' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Background $background): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Background::class;
    }
}
