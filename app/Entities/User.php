<?php

namespace App\Entities;

use Timon\PhpFramework\Authenticate\AuthUserInterface;

class User implements AuthUserInterface
{
    public function __construct(
        private ?int $id = null,
        private string $name,
        private string $email,
        private string $password,
        private \DateTimeImmutable|null $created_at = null
    ) {}

    public static function create(string $email, string $password, ?string $name = null, ?int $id = null, ?\DateTimeImmutable $created_at = null): static
    {
        return new static($id, $name, $email, $password, $created_at ?? new \DateTimeImmutable());
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCreated_at()
    {
        return $this->created_at;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


}
