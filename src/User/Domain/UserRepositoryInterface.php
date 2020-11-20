<?php

declare(strict_types=1);

namespace App\User\Domain;

interface UserRepositoryInterface
{
    public function nextId(): UserId;

    public function register(User $user): void;

    public function findByUsername(string $username): User;
}
