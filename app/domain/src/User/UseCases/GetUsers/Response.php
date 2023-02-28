<?php

declare(strict_types=1);

namespace Domain\User\UseCases\GetUsers;

use Domain\User\List\UserList;

class Response
{
    private UserList $users;

    public function __construct(UserList $users)
    {
        $this->users = $users;
    }

    public function response(): array
    {
        $response = [];

        foreach ($this->users as $user) {
            $response[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email(),
            ];
        }
        return $response;
    }
}
