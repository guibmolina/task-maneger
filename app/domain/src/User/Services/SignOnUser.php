<?php

declare(strict_types=1);

namespace Domain\User\Services;

use Domain\User\Entities\UserEntity;
use Domain\User\Exceptions\FailedToSignOnUserException;


interface SignOnUser
{
    /**
     * @throws FailedToSignOnUserException
     */
    public function signOn(UserEntity $user): UserEntity;
}