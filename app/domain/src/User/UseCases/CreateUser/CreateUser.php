<?php

declare(strict_types=1);

namespace Domain\User\UseCases\CreateUser;

use Domain\User\Entities\UserEntity;
use Domain\User\Repositories\UserRepository;
use Domain\User\Services\SignOnUser;

class CreateUser
{
    public UserRepository $repository;

    public SignOnUser $service;

    public function __construct(UserRepository $repository, SignOnUser $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function execute(DTO $DTO): Response
    {
        $user = new UserEntity(null, $DTO->name, $DTO->email, $DTO->password, null);

        $user->setPasswordHash($DTO->password);

        $userSaved = $this->repository->create($user);

        $userAuthenticated = $this->service->signOn($userSaved);

        return new Response($userAuthenticated);
    }   
}

