<?php

declare(strict_types=1);

namespace Domain\User\List;

use ArrayIterator;
use Domain\User\Entities\UserEntity;
use IteratorAggregate;
use Traversable;

/** @implements IteratorAggregate<Setting> */
class UserList implements IteratorAggregate
{
    /** @var array<UserEntity> */
    private array $users;

    public function __construct()
    {
        $this->users = [];
    }

    public function add(UserEntity $user): void
    {
        $this->users[] = $user;
    }

    /** @return array<UserEntity> */
    public function products(): array
    {
        return $this->users;
    }

    /** @return Traversable<UserEntity> */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->users);
    }
}
