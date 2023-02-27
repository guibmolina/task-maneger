<?php

declare(strict_types=1);

namespace Tests\Domain\Unit\User\UseCases\SignOnUser;

use Domain\User\Entities\UserEntity;
use Domain\User\UseCases\SignOnUser\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public UserEntity $userEntity;


    public function setUp(): void
    {
        /** @var UserEntity $userEntity */
        $this->userEntity = $this->getMockBuilder(UserEntity::class)
            ->setConstructorArgs(['1', 'guilherme', 'guilherme@test.com.br', '123456', 'xpto1234'])
            ->getMock();
    }

    /** @test */
    public function itShouldReturnAnArray():void
    {
        $response = new Response($this->userEntity);

        $this->assertIsArray($response->response());
    }
}