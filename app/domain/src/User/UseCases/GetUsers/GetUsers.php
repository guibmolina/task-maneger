<?php

declare(strict_types=1);

namespace Domain\User\UseCases\GetUsers;

use Domain\User\Repositories\UserRepository;

class GetUsers
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): Response
    {
        $users = $this->repository->allUsers();

        return new Response($users);
    }
}
