<?php

namespace App\Features\User\Auth\DTOs;

use Illuminate\Http\Request;

class AdminLoginDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly bool $remember
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            email: $request->input('email'),
            password: $request->input('password'),
            remember: $request->boolean('remember')
        );
    }
}
