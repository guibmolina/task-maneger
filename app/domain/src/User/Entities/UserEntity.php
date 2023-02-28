<?php

declare(strict_types=1);

namespace Domain\User\Entities;

use Domain\User\Exceptions\EmailInvalidException;


class UserEntity
{
    public ?int $id = null;

    public ?string $name;

    private string $email;

    public string $password;

    public ?string $token = null;

    public function __construct(
        ?int $id,
        ?string $name,
        string $email,
        string $password,
        ?string $token
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $this->checkEmail($email);
        $this->password = $password;
        $this->token = $token;
    }

    private function checkEmail($email): string
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $email;
        }
        
        throw new EmailInvalidException('Email invalid');
    }

    public function email(): string
    {
        return $this->email;
    }

    public function setPasswordHash(string $password):void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
}
