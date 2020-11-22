<?php

declare(strict_types=1);

namespace App\Tests\ObjectMother;

use App\Article\Domain\Article;
use App\Article\Domain\ArticleId;
use App\User\Domain\User;
use App\User\Domain\UserId;

class UserMother
{
    public const VALID_UUID = '23d35201-3abb-442c-a434-a88c622554d4';
    public const USERNAME = 'username';

    public static function anyWithUuid(string $uuid = self::VALID_UUID, string $username = self::USERNAME): USer
    {
        $user = new User(
            UserId::fromString(self::VALID_UUID),
            self::USERNAME,
            'email@exmaple.com'
        );
        $user->setToken(self::VALID_UUID);

        return $user;
    }
}
