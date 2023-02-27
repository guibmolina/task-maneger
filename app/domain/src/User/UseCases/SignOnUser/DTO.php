<?php

declare(strict_types=1);

namespace Domain\User\UseCases\SignOnUser;

use Domain\User\Entities\UserEntity;

class DTO
{
    public UserEntity $user;

    public function __construct(UserEntity $user)
    {
        $this->user = $user;
    }
}
