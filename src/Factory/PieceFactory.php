<?php

namespace App\Factory;

use App\Entity\Piece;
use App\Entity\PieceBodyTypeEnum;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Piece>
 */
final class PieceFactory extends PersistentProxyObjectFactory
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
        return Piece::class;
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
            'name' => self::faker()->unique()->text(255),
            'bodyType' => self::faker()->randomElement(PieceBodyTypeEnum::cases()),
            'thumbnail' => self::faker()->imageUrl(),
            'seasons' => SeasonFactory::randomRange(0, 4),
            'category' => CategoryFactory::random(),
            'tags' => TagFactory::randomRange(0, 4),
            'deleted' => self::faker()->boolean(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Piece $piece): void {})
        ;
    }
}
