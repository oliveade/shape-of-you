<?php

namespace App\Factory;

use App\Entity\Outfit;
use Zenstruck\Foundry\LazyValue;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Outfit>
 */
final class OutfitFactory extends PersistentProxyObjectFactory
{
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
        return Outfit::class;
    }

    public function published(): self
    {
        return $this->with([
            'published' => true,
        ]);
    }

    public function unpublished(): self
    {
        return $this->with([
            'published' => false,
        ]);
    }

    public function deleted(): self
    {
        return $this->with([
            'deleted' => true,
        ]);
    }

    public function undeleted(): self
    {
        return $this->with([
            'deleted' => false,
        ]);
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $owner = LazyValue::memoize(fn () => UserFactory::random());

        return [
            'owner' => $owner,
            'pieces' => PieceFactory::new(['users' => [$owner]])->many(5),
            'seasons' => LazyValue::new(fn () => SeasonFactory::randomRange(0, 4)),
            'tags' => TagFactory::randomRange(0, 4),
            'published' => self::faker()->boolean(),
            'deleted' => false,
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Outfit $outfit): void {})
        ;
    }
}
