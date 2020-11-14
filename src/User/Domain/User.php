<?php

declare(strict_types=1);

namespace App\User\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    public function getRoles(): void
    {
        // TODO: Implement getRoles() method.
    }

    public function getPassword(): void
    {
        // TODO: Implement getPassword() method.
    }

    public function getSalt(): void
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername(): void
    {
        // TODO: Implement getUsername() method.
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }
}
