<?php


namespace App\Features\Auth\DTOs;

use App\Http\Requests\LoginRequest;

class LoginDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly bool $remember
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
