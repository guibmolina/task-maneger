<?php

declare(strict_types=1);

namespace Infra\User\Repositories;

use App\Models\User;
use Domain\User\Entities\UserEntity;
use Domain\User\Exceptions\NotCreateUserException;
use Domain\User\Repositories\UserRepository as BaseUserRepository;
use Exception;

class UserRepository implements BaseUserRepository
{
    public function create(UserEntity $userEntity): UserEntity
    {
        $user = new User();
        $user->name = $userEntity->name;
        $user->email = $userEntity->email();
        $user->password = $userEntity->password;

        try {
            $user->save();
        } catch (Exception $e) {
            throw new NotCreateUserException();
        }

        return $this->mapUserEntityDomain($user);
    }

    private function mapUserEntityDomain(User $user): UserEntity
    {
        return new UserEntity(
            $user->id,
            $user->name,
            $user->email,
            $user->password,
            null
        );
    }
}
