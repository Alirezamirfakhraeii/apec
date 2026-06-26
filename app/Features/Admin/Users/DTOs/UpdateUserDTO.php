<?php

namespace App\Features\Admin\Users\DTOs;

final readonly class UpdateUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $password = null,
        public ?string $role = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: ! empty($data['password']) ? $data['password'] : null,
            role: $data['role'] ?? null,
        );
    }
}
