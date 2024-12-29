<?php

namespace App\Entities;


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
        return new static($id, $title, $body, $created_at);
    }
}
