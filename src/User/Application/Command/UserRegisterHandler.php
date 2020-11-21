<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\CQRS\CommandHandler;
use App\User\Domain\User;
use App\User\Domain\UserRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserRegisterHandler implements CommandHandler
{
    private UserRepositoryInterface $repository;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserRepositoryInterface $repository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->repository = $repository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function __invoke(UserRegisterCommand $command): void
    {
        $user = new User(
            $this->repository->nextId(),
            $command->getUsername(),
            $command->getEmail()
        );
        $user->setPassword($this->passwordEncoder->encodePassword($user, $command->getPassword()));
        $user->setToken(Uuid::uuid4()->toString());
        $this->repository->register($user);
    }
}
