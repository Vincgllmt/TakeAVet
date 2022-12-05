<?php

namespace App\Factory;

use App\Entity\Animal;
use App\Repository\AnimalRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Animal>
 *
 * @method static Animal|Proxy createOne(array $attributes = [])
 * @method static Animal[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Animal[]|Proxy[] createSequence(array|callable $sequence)
 * @method static Animal|Proxy find(object|array|mixed $criteria)
 * @method static Animal|Proxy findOrCreate(array $attributes)
 * @method static Animal|Proxy first(string $sortedField = 'id')
 * @method static Animal|Proxy last(string $sortedField = 'id')
 * @method static Animal|Proxy random(array $attributes = [])
 * @method static Animal|Proxy randomOrCreate(array $attributes = [])
 * @method static Animal[]|Proxy[] all()
 * @method static Animal[]|Proxy[] findBy(array $attributes)
 * @method static Animal[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Animal[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static AnimalRepository|RepositoryProxy repository()
 * @method Animal|Proxy create(array|callable $attributes = [])
 */
final class AnimalFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'name' => self::faker()->text(),
            'birthday' => self::faker()->dateTime(),
            'gender' => self::faker()->text(),
            'isDomestic' => self::faker()->boolean(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Animal $animal): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Animal::class;
    }
}
