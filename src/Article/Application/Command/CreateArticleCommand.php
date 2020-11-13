<?php

declare(strict_types=1);

namespace App\Article\Application\Command;

use App\Shared\Application\CQRS\Command;

final class CreateArticleCommand implements Command
{
    private string $title;

    private string $description;

    private string $body;

    private array $tags;

    private function __construct(string $title, string $description, string $body, array $tags)
    {
        $this->title = $title;
        $this->description = $description;
        $this->body = $body;
        $this->tags = $tags;
    }

    public static function create(string $title, string $description, string $body, array $tags): self
    {
        return new static($title, $description, $body, $tags);
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

    public function getTags(): array
    {
        return $this->tags;
    }
}
