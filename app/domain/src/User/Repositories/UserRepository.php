<?php

declare(strict_types=1);

namespace Domain\User\Repositories;

use Domain\User\Entities\UserEntity;
use Domain\User\Exceptions\NotCreateUserException;


interface UserRepository
{
    /**
     * @throws NotCreateUserException
     */
    public function create(UserEntity $user): UserEntity;

    
}
