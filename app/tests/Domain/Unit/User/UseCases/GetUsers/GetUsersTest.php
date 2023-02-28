<?php

declare(strict_types=1);

namespace Tests\Domain\Unit\User\UseCases\GetUsers;

use Domain\User\List\UserList;
use Domain\User\Repositories\UserRepository;
use Domain\User\UseCases\GetUsers\GetUsers;
use Domain\User\UseCases\GetUsers\Response;
use PHPUnit\Framework\TestCase;

class GetUsersTest extends TestCase
{
    private UserRepository $repository;

    private UserList $userList;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->getMockBuilder(UserRepository::class)
            ->getMock();

        $this->userList = $this->getMockBuilder(UserList::class)->getMock();
    }

    /** @test */
    public function itShouldReturnInstanceOfResponse(): void
    {

        $this->repository->expects($this->once())
        ->method('allUsers')
        ->willReturn($this->userList);

        $getUsersUseCase = new GetUsers($this->repository);

        $users = $getUsersUseCase->execute();

        self::assertInstanceOf(Response::class, $users);
    }
}
