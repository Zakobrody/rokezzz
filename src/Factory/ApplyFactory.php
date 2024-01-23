<?php

namespace App\Factory;

use App\Entity\Apply;
use App\Repository\ApplyRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Apply>
 *
 * @method        Apply|Proxy create(array|callable $attributes = [])
 * @method static Apply|Proxy createOne(array $attributes = [])
 * @method static Apply|Proxy find(object|array|mixed $criteria)
 * @method static Apply|Proxy findOrCreate(array $attributes)
 * @method static Apply|Proxy first(string $sortedField = 'id')
 * @method static Apply|Proxy last(string $sortedField = 'id')
 * @method static Apply|Proxy random(array $attributes = [])
 * @method static Apply|Proxy randomOrCreate(array $attributes = [])
 * @method static ApplyRepository|RepositoryProxy repository()
 * @method static Apply[]|Proxy[] all()
 * @method static Apply[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Apply[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Apply[]|Proxy[] findBy(array $attributes)
 * @method static Apply[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Apply[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class ApplyFactory extends ModelFactory
{
    private const LEVELS = ['junior', 'regular', 'senior'];
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
        $expectedSalary = self::faker()->numberBetween(3000, 20000);
        return [
//            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'email' => self::faker()->email(),
            'expectedSalary' => $expectedSalary,
            'firstname' => self::faker()->firstName(),
            'lastname' => self::faker()->lastName(),
            'level' => self::setLevel($expectedSalary),
            'phone' => self::faker()->phoneNumber(),
            'position' => self::faker()->text(16),
            'isRead' => self::faker()->boolean(25)
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Apply $apply): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Apply::class;
    }

    protected static function setLevel($expectedSalary): string
    {
        if ($expectedSalary < 5000) {
            return 'junior';
        } elseif ($expectedSalary < 10000) {
            return 'regular';
        } else {
            return 'senior';
        }
    }
}
