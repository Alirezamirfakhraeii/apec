<?php

namespace App\Features\User\Auth\DTOs;

readonly class RegisterData {
    public function __construct(
        public string $email,
        public string $password,
        public ?string $mobile = null,
        public string $name,
    ) {}

    public static function fromRequest($request): self {
        return new self(...$request->validated());
    }
}
