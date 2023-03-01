<?php

declare(strict_types=1);

namespace Tests\Domain\Unit\User\UseCases\GetUsers;

use Domain\User\List\UserList;
use Domain\User\UseCases\GetUsers\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    private UserList $userList;

    public function setUp(): void
    {
        parent::setUp();

        $this->userList = $this->getMockBuilder(UserList::class)
        ->disableOriginalConstructor()
        ->getMock();
    }

    /** @test */
    public function itMustReturnAnArray(): void
    {
        $reponse = new Response($this->userList);

        self::assertIsArray($reponse->response());
    }
}
