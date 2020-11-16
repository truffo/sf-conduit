<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\CQRS\Command;

final class UserRegisterCommand implements Command
{
    private string $email;
    private string $password;
    private string $username;

    public function __construct(string $username, string $password, string $email)
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
