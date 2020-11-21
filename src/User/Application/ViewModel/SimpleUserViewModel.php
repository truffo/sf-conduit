<?php


namespace App\User\Application\ViewModel;


use App\Shared\Application\ViewModel;
use App\User\Domain\User;

final class SimpleUserViewModel implements ViewModel
{
    private string $username;
    private string $email;
    private string $token;
    private string $bio;
    private string $image;

    private function __construct(
        string $username,
        string $email,
        string $token,
        string $bio,
        string $image
    )
    {
        $this->username = $username;
        $this->email = $email;
        $this->token = $token;
        $this->bio = $bio;
        $this->image = $image;
    }

    public static function createFromEntity(User $user): self
    {
        return new self(
            $user->getUsername(),
            $user->getEmail(),
            $user->getToken(),
            '',
            ''
        );
    }

    public function value()
    {
        return [
            'user' => [
                'username' => $this->username,
                'email' => $this->email,
                'token' => $this->token,
                'bio' => $this->bio,
                'image' => $this->image,
            ],
        ];
    }
}