<?php

namespace App\Entities;

use DateTimeImmutable;

class Post
{
    public function  __construct(
        private ?int $id,
        private ?string $title,
        private ?string $body,
        private ?\DateTimeImmutable $created_at
    ) {}

    public static function create(string $title, string $body, ?int $id = null, \DateTimeImmutable $created_at = null): static
    {
        return new static($id, $title, $body, $created_at ?? new \DateTimeImmutable());
    }

    public function id(): int|null
    {
        return $this->id;
    }

    public function title(): string|null
    {
        return $this->title;
    }

    public function body(): string|null
    {
        return $this->body;
    }


    public function created_at(): DateTimeImmutable|null
    {
        return $this->created_at;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }
}
