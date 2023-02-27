<?php

declare(strict_types=1);

namespace Domain\User\UseCases\SignOnUser;

use Domain\User\Services\SignOnUser as SignOnUserService;

class SignOnUser
{
    public SignOnUserService $service;

    public function __construct(SignOnUserService $service)
    {
        $this->service = $service;
    }

    public function execute(DTO $DTO): Response
    {
        $userAuthenticated = $this->service->signOn($DTO->user);

        return new Response($userAuthenticated);
    }
}