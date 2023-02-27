<?php

declare(strict_types=1);

namespace Domain\User\UseCases\CreateUser;

use Domain\User\Entities\UserEntity;

class Response
{
    private UserEntity $entity;

    public function __construct(UserEntity $entity)
    {
        $this->entity = $entity;
    }

    public function response(): array
    {
        return [
            'id' => $this->entity->id,
            'token' => $this->entity->token
        ];
    }
}