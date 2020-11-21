<?php


namespace App\User\Application\Query;

use App\Shared\Application\CQRS\Query;

class FindByUsernameQuery implements Query
{
    private string $username;

    public function __construct(string $username)
    {
        $this->username = $username;
   }

    public function getUsername(): string
    {
        return $this->username;
    }
}