<?php

namespace App\Features\Admin\Media\DTOs;


use App\Http\Requests\Admin\Media\UpdateMediaRequest;

class UpdateMediaData
{
    public function __construct(
        public readonly ?string $alt,
        public readonly ?string $caption,
    ) {
    }

    public static function fromRequest(UpdateMediaRequest $request): self
    {
        return new self(
            alt: $request->validated('alt'),
            caption: $request->validated('caption'),
        );
    }

    public function toArray(): array
    {
        return [
            'alt' => $this->alt,
            'caption' => $this->caption,
        ];
    }
}
