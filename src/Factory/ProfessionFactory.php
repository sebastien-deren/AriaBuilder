<?php

namespace App\Factory;

use App\PersonnageCreator\Domain\Model\Profession;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Profession>
 *
 * @method        Profession|Proxy                 create(array|callable $attributes = [])
 * @method static Profession|Proxy                 createOne(array $attributes = [])
 * @method static Profession|Proxy                 find(object|array|mixed $criteria)
 * @method static Profession|Proxy                 findOrCreate(array $attributes)
 * @method static Profession|Proxy                 first(string $sortedField = 'id')
 * @method static Profession|Proxy                 last(string $sortedField = 'id')
 * @method static Profession|Proxy                 random(array $attributes = [])
 * @method static Profession|Proxy                 randomOrCreate(array $attributes = [])
 * @method static EntityRepository|RepositoryProxy repository()
 * @method static Profession[]|Proxy[]             all()
 * @method static Profession[]|Proxy[]             createMany(int $number, array|callable $attributes = [])
 * @method static Profession[]|Proxy[]             createSequence(iterable|callable $sequence)
 * @method static Profession[]|Proxy[]             findBy(array $attributes)
 * @method static Profession[]|Proxy[]             randomRange(int $min, int $max, array $attributes = [])
 * @method static Profession[]|Proxy[]             randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<Profession> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Profession> createOne(array $attributes = [])
 * @phpstan-method static Proxy<Profession> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<Profession> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<Profession> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<Profession> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<Profession> random(array $attributes = [])
 * @phpstan-method static Proxy<Profession> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<Profession> repository()
 * @phpstan-method static list<Proxy<Profession>> all()
 * @phpstan-method static list<Proxy<Profession>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<Profession>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<Profession>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<Profession>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<Profession>> randomSet(int $number, array $attributes = [])
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
            'competenceProfessions' => new ArrayCollection([CompetenceFactory::createOne()]),
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
}
