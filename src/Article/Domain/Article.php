<?php

declare(strict_types=1);

namespace App\Article\Domain;

use DateTimeImmutable;
use DateTimeInterface;

class Article
{
    private ArticleId $id;

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
        ArticleId $id,
        string $slug,
        string $title,
        string $description,
        string $body,
        array $tagList,
        bool $favorited,
        int $favoritesCount
    ) {
        $now = new DateTimeImmutable();
        $this->id = $id;
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->body = $body;
        $this->tagList = $tagList;
        $this->createdAt = $now;
        $this->updatedAt = $now;
        $this->favorited = $favorited;
        $this->favoritesCount = $favoritesCount;
    }

    public static function create(
        ArticleId $id,
        string $title,
        string $body,
        string $description,
        array $tagList
    ): self {
        return new self($id, $title, $title, $description, $body, $tagList, false, 0);
    }

    public function getId(): ArticleId
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getTagList(): array
    {
        return $this->tagList;
    }

    /**
     * @return DateTimeImmutable|DateTimeInterface
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return DateTimeImmutable|DateTimeInterface
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function isFavorited(): bool
    {
        return $this->favorited;
    }

    public function getFavoritesCount(): int
    {
        return $this->favoritesCount;
    }
}
