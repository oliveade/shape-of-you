<?php

namespace App\Factory;

use App\Entity\Garment;
use Zenstruck\Foundry\LazyValue;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Garment>
 */
final class GarmentFactory extends PersistentProxyObjectFactory
{
    private const COLORNAMES = [
        'red',
        'orange',
        'yellow',
        'green',
        'blue',
        'purple',
        'pink',
        'gray',
    ];

    private const TYPENAMES = [
        't-shirt',
        'jeans',
        'pants',
        'jogging',
        'blazer',
        'pull',
        'suit',
        'tracksuit',
        'shoes',
        'jewelry',
    ];

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Garment::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $user = LazyValue::memoize(fn () => UserFactory::random());
        $color = LazyValue::memoize(fn () => self::faker()->randomElement(self::COLORNAMES));
        $type = LazyValue::memoize(fn () => self::faker()->randomElement(self::TYPENAMES));

        return [
            'color' => $color,
            'imageUrl' => self::faker()->imageUrl(),
            'type' => $type,
            'users' => $user,
            'deleted' => false,
            // 'isShared' => self::faker()->boolean(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Garment $garment): void {})
        ;
    }
}
