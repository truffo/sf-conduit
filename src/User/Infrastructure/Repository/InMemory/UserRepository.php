<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Repository\InMemory;

use App\User\Domain\User;
use App\User\Domain\UserId;
use App\User\Domain\UserRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;

class UserRepository implements UserRepositoryInterface
{
    private ArrayCollection $data;

    public function __construct()
    {
        $this->data = new ArrayCollection();
    }

    public function nextId(): UserId
    {
        return UserId::fromString(Uuid::uuid4()->toString());
    }

    public function register(User $user): void
    {
        $this->data->add($user);
    }
}
