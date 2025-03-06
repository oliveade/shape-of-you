<?php

namespace App\Factory;

use App\Entity\User;
use App\Entity\UserStatusEnum;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<User>
 */
final class UserFactory extends PersistentProxyObjectFactory
{
    private $passwordHasher;

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();

        $this->passwordHasher = $passwordHasher;
    }

    public static function class(): string
    {
        return User::class;
    }

    public function isAdmin(): self
    {
        return $this->with([
            'roles' => [User::ROLE_ADMIN],
        ]);
    }

    public function activated(): self
    {
        return $this->with([
            'status' => UserStatusEnum::ACTIVE,
        ]);
    }

    public function banned(): self
    {
        return $this->with([
            'status' => UserStatusEnum::BANNED,
        ]);
    }

    public function bannedAt(): self
    {
        return $this->with([
            'bannedAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-1 year', 'now')),
        ]);
    }

    public function deleted(): self
    {
        return $this->with([
            'status' => UserStatusEnum::DELETED,
        ]);
    }

    public function deletedAt(): self
    {
        return $this->with([
            'deletedAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-1 year', 'now')),
        ]);
    }

    public function pending(): self
    {
        return $this->with([
            'status' => UserStatusEnum::PENDING,
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
            'firstName' => self::faker()->firstName(),
            'lastName' => self::faker()->lastName(),
            'email' => self::faker()->unique()->safeEmail(),
            'password' => 'azeqsdwxc',
            'roles' => [User::ROLE_USER],
            'status' => self::faker()->randomElement(UserStatusEnum::cases()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            ->afterInstantiate(function (User $user) {
                $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
            })
        ;
    }
}
