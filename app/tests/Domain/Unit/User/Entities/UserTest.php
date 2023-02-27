<?php

declare(strict_types =1);

namespace Tests\Domain\Unit\User\Entities;

use Domain\User\Entities\UserEntity;
use Domain\User\Exceptions\EmailInvalidException;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function itShouldNotAcceptInvalidEmail(): void
    {
        $this->expectException(EmailInvalidException::class);

         new UserEntity(
            12,
            'Guilherme',
            'guilherme.com.br',
            '123456',
            null
         );
    }

    /** @test */
    public function itShouldHashPassowd():void
    {
        $user = new UserEntity(
            12,
            'Guilherme',
            'guilherme@test.com.br',
            '123456',
            null
        );

        $user->setPasswordHash('123456');

        $this->assertNotEquals($user->password, '123456');
        $this->assertTrue(password_verify('123456', $user->password));
    }
}
