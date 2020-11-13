<?php

declare(strict_types=1);

namespace App\Article\Application\Query;

use App\Shared\Application\CQRS\Query;

final class GetArticleQuery implements Query
{
    private string $slug;

    public function __construct(string $slug)
    {
        $this->slug = $slug;
    }

    public static function create(string $slug)
    {
        return new self($slug);
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}
