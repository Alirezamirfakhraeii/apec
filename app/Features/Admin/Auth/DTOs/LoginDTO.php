<?php

namespace App\Features\Admin\Auth\DTOs;

use App\Http\Requests\LoginRequest;

readonly class LoginDTO
{
    public function __construct(
        public string $email,
        public string $password,
        public bool   $remember
    ) {}

    /**
     * ساخت خودکار DTO از روی ریکوئست اعتبارسنجی شده
     */
    public static function fromRequest(LoginRequest $request): self
    {
        return new self(
            email: $request->validated('email'),
            password: $request->validated('password'),
            remember: $request->has('remember')
        );
    }
}
