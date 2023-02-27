<?php

declare(strict_types=1);

namespace Domain\User\UseCases\SignOnUser;

use Domain\User\Entities\UserEntity;

class Response
{
    public UserEntity $entity;
    
    public function __construct(UserEntity $entity)
    {
        $this->entity = $entity;
    }

    public function response(): array
    {
        return [
            'token' => $this->entity->token,
        ];
    }
}
