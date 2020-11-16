<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\CQRS\CommandHandler;
use App\User\Domain\User;
use App\User\Domain\UserRepositoryInterface;

final class UserRegisterHandler implements CommandHandler
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UserRegisterCommand $command): void
    {
        $user = new User(
            $this->repository->nextId(),
            $command->getUsername(),
            $command->getEmail(),
            $command->getPassword()
        );
        $this->repository->register($user);
    }
}
