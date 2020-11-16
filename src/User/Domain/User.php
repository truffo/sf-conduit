<?php

declare(strict_types=1);

namespace App\User\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    private UserId $id;
    private string $username;
    private string $email;
    private string $password;
    /**
     * @var array<string>
     */
    private array $roles = [];

    public function __construct(UserId $userId, string $username, string $email, string $password)
    {
        $this->id = $userId;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return string[] The user roles
     */
    public function getRoles()
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array<string> $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * Set the encoded password.
     */
    public function setPassword(string $encodePassword): void
    {
        $this->password = $encodePassword;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return null|string The salt
     */
    public function getSalt(): string
    {
        return '';
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials(): void
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
