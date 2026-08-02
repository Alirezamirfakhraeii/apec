<?php

namespace App\Features\Admin\Media\Actions;

use App\Features\Admin\Media\DTOs\StoreMediaData;
use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class StoreMediaAction
{
    /**
     * @return Collection<int, Media>
     *
     * @throws Throwable
     */
    public function execute(StoreMediaData $data): Collection
    {
        $storedPaths = [];

        try {
            return DB::transaction(function () use ($data, &$storedPaths) {
                return collect($data->files)
                    ->map(function (UploadedFile $file) use ($data, &$storedPaths) {
                        $media = $this->storeFile(
                            file: $file,
                            disk: $data->disk,
                            uploadedBy: $data->uploadedBy,
                        );

                        $storedPaths[] = [
                            'disk' => $media->disk,
                            'path' => $media->path,
                        ];

                        return $media;
                    });
            });
        } catch (Throwable $exception) {
            foreach ($storedPaths as $storedFile) {
                Storage::disk($storedFile['disk'])
                    ->delete($storedFile['path']);
            }

            throw $exception;
        }
    }

    private function storeFile(
        UploadedFile $file,
        string $disk,
        ?int $uploadedBy,
    ): Media {
        $directory = 'media/' . now()->format('Y/m');

        $extension = strtolower(
            $file->getClientOriginalExtension()
                ?: $file->extension()
                ?: 'bin'
        );

        $filename = Str::uuid() . '.' . $extension;

        $path = $file->storeAs(
            $directory,
            $filename,
            $disk
        );

        $mimeType = $file->getMimeType();
        $type = $this->resolveType($mimeType);

        [$width, $height] = $this->resolveDimensions(
            file: $file,
            type: $type
        );

        return Media::query()->create([
            'disk' => $disk,
            'path' => $path,
            'url' => Storage::disk($disk)->url($path),

            'type' => $type,
            'mime_type' => $mimeType,

            'size' => $file->getSize(),
            'width' => $width,
            'height' => $height,

            'alt' => pathinfo(
                $file->getClientOriginalName(),
                PATHINFO_FILENAME
            ),

            'caption' => null,
            'is_main' => false,
            'uploaded_by' => $uploadedBy,
        ]);
    }

    private function resolveType(?string $mimeType): string
    {
        if (!$mimeType) {
            return 'file';
        }

        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        }

        if (str_starts_with($mimeType, 'audio/')) {
            return 'audio';
        }

        if (str_starts_with($mimeType, 'video/')) {
            return 'video';
        }

        if ($mimeType === 'application/pdf') {
            return 'pdf';
        }

        return 'file';
    }

    /**
     * @return array{0: int|null, 1: int|null}
     */
    private function resolveDimensions(
        UploadedFile $file,
        string $type,
    ): array {
        if ($type !== 'image') {
            return [null, null];
        }

        $dimensions = @getimagesize($file->getRealPath());

        if ($dimensions === false) {
            return [null, null];
        }

        return [
            $dimensions[0] ?? null,
            $dimensions[1] ?? null,
        ];
    }
}
