<?php

namespace App\Factory;

use App\Entity\Category;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Category>
 */
final class CategoryFactory extends PersistentProxyObjectFactory
{
    private const NAMES = [
        'clothing',
        'footwear',
        'accessories',
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
        return Category::class;
    }

    public function activated(): self
    {
        return $this->with([
            'active' => true,
        ]);
    }

    public function unactivated(): self
    {
        return $this->with([
            'active' => false,
        ]);
    }

    public function deleted(): self
    {
        return $this->with([
            'deleted' => true,
            'deleted_at' => self::faker()->dateTime(),
        ]);
    }

    public function undeleted(): self
    {
        return $this->with([
            'deleted' => false,
            'deleted_at' => null,
        ]);
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'name' => self::faker()->randomElement(self::NAMES),
            'active' => self::faker()->boolean(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Category $category): void {})
        ;
    }
}
