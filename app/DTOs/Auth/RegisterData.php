<?php

namespace App\DTOs\Auth;

readonly class RegisterData {
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public ?string $mobile = null,
    ) {}

    public static function fromRequest($request): self {
        return new self(...$request->validated());
    }
}
