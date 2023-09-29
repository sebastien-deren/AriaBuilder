<?php

namespace App\Factory;

use App\Domain\Model\Competence;
use App\Repository\CompetenceRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;


/**
 * @extends ModelFactory<Competence>
 *
 * @method        Competence|Proxy                     create(array|callable $attributes = [])
 * @method static Competence|Proxy                     createOne(array $attributes = [])
 * @method static Competence|Proxy                     find(object|array|mixed $criteria)
 * @method static Competence|Proxy                     findOrCreate(array $attributes)
 * @method static Competence|Proxy                     first(string $sortedField = 'id')
 * @method static Competence|Proxy                     last(string $sortedField = 'id')
 * @method static Competence|Proxy                     random(array $attributes = [])
 * @method static Competence|Proxy                     randomOrCreate(array $attributes = [])
 * @method static CompetenceRepository|RepositoryProxy repository()
 * @method static Competence[]|Proxy[]                 all()
 * @method static Competence[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Competence[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Competence[]|Proxy[]                 findBy(array $attributes)
 * @method static Competence[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Competence[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class CompetenceFactory extends ModelFactory
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
            'isBaseCompetence' => self::faker()->boolean(),
            'nom' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Competence $competence): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Competence::class;
    }

    public function based(): self
    {
        $carac = ['Force', 'Intelligence', 'Charisme', 'Endurance', 'Dexterite'];
        return $this->addState([
            'isBaseCompetence' => true,
            'firstCharac' => $carac[\rand(0, 4)],
            'secondCharac' => $carac[\rand(0, 4)],
        ]);
    }
}
