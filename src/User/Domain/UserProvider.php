<?php

declare(strict_types=1);

namespace App\User\Domain;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function loadUserByUsername(string $token)
    {
        return $this->repository->findByToken($token);
    }

    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    public function supportsClass(string $class)
    {
        return User::class;
    }
}
