<?php

namespace App\Features\Admin\Media\Actions;

use App\Models\Media;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class DeleteMediaAction
{
    public function execute(Media $media): void
    {
        $disk = $media->disk;
        $path = $media->path;

        if (
            $path &&
            Storage::disk($disk)->exists($path) &&
            !Storage::disk($disk)->delete($path)
        ) {
            throw new RuntimeException(
                'حذف فایل رسانه از فضای ذخیره‌سازی انجام نشد.'
            );
        }

        $media->delete();
    }
}
