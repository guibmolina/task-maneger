<?php

declare(strict_types=1);

namespace Domain\User\UseCases\CreateUser;

use Domain\User\Entities\UserEntity;
use Domain\User\Repositories\UserRepository;

class CreateUser
{
    public UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(DTO $DTO): Response
    {
        $user = new UserEntity(null, $DTO->name, $DTO->email, $DTO->password, null);

        $user->setPasswordHash($DTO->password);

        $userSaved = $this->repository->create($user);

        return new Response($userSaved);
    }   
}
