<?php

declare(strict_types=1);

namespace Domain\User\Repositories;

use Domain\User\Entities\UserEntity;
use Domain\User\Exceptions\NotCreateUserException;
use Domain\User\List\UserList;

interface UserRepository
{
    /**
     * @throws NotCreateUserException
     */
    public function create(UserEntity $user): UserEntity;

    public function allUsers(): UserList;

    public function findUsersByIds(array $usersId): UserList;
    
}
