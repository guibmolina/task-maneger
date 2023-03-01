<?php

namespace Tests\Domain\Unit\User\List;

use Domain\User\Entities\UserEntity;
use Domain\User\List\UserList;
use PHPUnit\Framework\TestCase;
use Traversable;

class ListUserTest extends TestCase
{
    private UserEntity $user;

    private UserList $userList;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->getMockBuilder(UserEntity::class)
        ->disableOriginalConstructor()
        ->getMock();

        $this->userList = new UserList();

        $this->userList->add($this->user);
    }

    /** @test */
    public function itMustReturnAnArrayOfUsers(): void
    {
        self::assertIsArray($this->userList->users());
        self::assertInstanceOf(UserEntity::class, $this->userList->users()[0]);
    }

    /** @test */
    public function itMustReturnAnIterator(): void
    {
        self::assertInstanceOf(Traversable::class, $this->userList->getIterator());
    }
}
