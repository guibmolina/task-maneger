<?php

declare(strict_types=1);

namespace Tests\Domain\Unit\User\UseCases\CreateUser;

use Domain\User\Exceptions\FailedToSignOnUserException;
use Domain\User\Exceptions\NotCreateUserException;
use Domain\User\Repositories\UserRepository;
use Domain\User\UseCases\CreateUser\CreateUser;
use Domain\User\UseCases\CreateUser\DTO;
use Domain\User\UseCases\CreateUser\Response;
use PHPUnit\Framework\TestCase;

class CreateUserTest extends TestCase
{
    public UserRepository $repository;

    public Response $response;

    public DTO $DTO;

    public function setUp(): void
    {
        parent::setUp();

        /** @var UserRepository $repository */
        $this->repository = $this->getMockBuilder(UserRepository::class)->getMock();

        /** @var Response $response */
        $this->response = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();

        /** @var DTO $DTO */
        $this->DTO = $this->getMockBuilder(DTO::class)
            ->setConstructorArgs(['Guilherme', 'guilherme@test.com.br', '123456'])
            ->getMock();
    }

    /** @test */
    public function itShoudReturnAResponse(): void
    {
        $this->repository->expects($this->once())
            ->method('create');

        $useCase = new CreateUser($this->repository);

        $this->assertInstanceOf(Response::class, $useCase->execute($this->DTO));

    }

    /** @test */
    public function itShouldThrowExceptionWhenFailedToCreateAnUser(): void
    {
        $this->expectException(NotCreateUserException::class);

        $this->repository->expects($this->once())
            ->method('create')
            ->will($this->throwException(
                new NotCreateUserException())
            );

        $useCase = new CreateUser($this->repository);

        $useCase->execute($this->DTO);
    }
}
