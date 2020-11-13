<?php

declare(strict_types=1);

namespace App\Article\Application\ViewModel\Article;

use App\Shared\Application\ViewModel;
use DateTimeInterface;

final class ArticleViewModel implements ViewModel
{
    private string $slug;

    private string $title;

    private string $description;

    private string $body;

    private array $tagList;

    private DateTimeInterface $createdAt;

    private DateTimeInterface $updatedAt;

    private bool $favorited;

    private int $favoritesCount;

    public function __construct(
        string $slug,
        string $title,
        string $description,
        string $body,
        array $tagList,
        DateTimeInterface $createdAt,
        DateTimeInterface $updatedAt,
        bool $favorited,
        int $favoritesCount
    ) {
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->body = $body;
        $this->tagList = $tagList;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->favorited = $favorited;
        $this->favoritesCount = $favoritesCount;
    }

    public function value(): array
    {
        return [
            'article' => [
                'slug' => $this->slug,
                'title' => $this->title,
                'description' => $this->description,
                'body' => $this->body,
                'tagList' => [...$this->tagList],
                'createdAt' => $this->createdAt,
                'updatedAt' => $this->updatedAt,
                'favorited' => $this->favorited,
                'favoritesCount' => $this->favoritesCount,
                'author' => [
                    'username' => 'string',
                    'bio' => 'string',
                    'image' => 'string',
                    'following' => true,
                ],
            ],
        ];
    }
}
