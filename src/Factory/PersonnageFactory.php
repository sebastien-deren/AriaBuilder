<?php

namespace App\Factory;

use App\Domain\Model\Personnage;
use App\Repository\PersonnageRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Personnage>
 *
 * @method        Personnage|Proxy                     create(array|callable $attributes = [])
 * @method static Personnage|Proxy                     createOne(array $attributes = [])
 * @method static Personnage|Proxy                     find(object|array|mixed $criteria)
 * @method static Personnage|Proxy                     findOrCreate(array $attributes)
 * @method static Personnage|Proxy                     first(string $sortedField = 'id')
 * @method static Personnage|Proxy                     last(string $sortedField = 'id')
 * @method static Personnage|Proxy                     random(array $attributes = [])
 * @method static Personnage|Proxy                     randomOrCreate(array $attributes = [])
 * @method static PersonnageRepository|RepositoryProxy repository()
 * @method static Personnage[]|Proxy[]                 all()
 * @method static Personnage[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Personnage[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Personnage[]|Proxy[]                 findBy(array $attributes)
 * @method static Personnage[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Personnage[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class PersonnageFactory extends ModelFactory
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
            'age' => (string)self::faker()->numberBetween(16, 89),
            'genie' => self::faker()->text(255),
            'nom' => self::faker()->lastName(),
            'prenom' => self::faker()->firstName(),
            'societe' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Personnage $personnage): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Personnage::class;
    }

    public function characterized(Proxy $carac): self
    {
        return $this->addState([
            "caracteristique" => $carac
        ]);
    }
}
