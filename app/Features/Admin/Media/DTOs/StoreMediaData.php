<?php

namespace App\Features\Admin\Media\DTOs;

use App\Http\Requests\Admin\Media\StoreMediaRequest;
use Illuminate\Http\UploadedFile;

class StoreMediaData
{
    /**
     * @param array<int, UploadedFile> $files
     */
    public function __construct(
        public readonly array $files,
        public readonly string $disk,
        public readonly ?int $uploadedBy,
    ) {
    }

    public static function fromRequest(StoreMediaRequest $request): self
    {
        return new self(
            files: $request->file('files', []),
            disk: $request->input('disk', 'public'),
            uploadedBy: $request->user()?->id,
        );
    }
}
