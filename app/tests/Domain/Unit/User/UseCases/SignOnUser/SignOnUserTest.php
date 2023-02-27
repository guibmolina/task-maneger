<?php

declare(strict_types=1);

namespace Tests\Domain\Unit\User\UseCases\SignOnUser;

use Domain\User\Entities\UserEntity;
use Domain\User\Exceptions\FailedToSignOnUserException;
use Domain\User\Services\SignOnUser as SignOnUserService;
use Domain\User\UseCases\SignOnUser\DTO;
use Domain\User\UseCases\SignOnUser\Response;
use Domain\User\UseCases\SignOnUser\SignOnUser;
use PHPUnit\Framework\TestCase;

class SignOnUserTest extends TestCase
{
    public UserEntity $userEntity;

    public SignOnUserService $service;

    public DTO $DTO;

  
    public function setUp(): void
    {
        parent::setUp();

        /** @var UserEntity $userEntity */
        $this->userEntity = $this->getMockBuilder(UserEntity::class)
        ->setConstructorArgs(['1', 'guilherme', 'guilherme@test.com.br', '123456', 'xpto1234'])
        ->getMock();

        /** @var SignOnUserService $service */
        $this->service = $this->getMockBuilder(SignOnUserService::class)->getMock();

        /** @var DTO $DTO */
        $this->DTO = $this->getMockBuilder(DTO::class)
            ->setConstructorArgs([$this->userEntity])
            ->getMock();
    }

    /** @test */
    public function itShoudReturnAResponse(): void
    {
        $this->service->expects($this->once())
            ->method('signOn');

        $useCase = new SignOnUser($this->service);

        $this->assertInstanceOf(Response::class, $useCase->execute($this->DTO));
    }

    /** @test */
    public function itShouldThrowExceptionWhenFailedToSignOnAnUser(): void
    {
        $this->expectException(FailedToSignOnUserException::class);
        
        $this->service->expects($this->once())
            ->method('signOn')
            ->will($this->throwException(
                new FailedToSignOnUserException())
            );

        $useCase = new SignOnUser($this->service);

        $useCase->execute($this->DTO);
    }
}