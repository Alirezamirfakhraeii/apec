<?php

namespace App\Features\Admin\Media\Actions;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;


class DownloadMediaAction
{
    public function execute(Media $media): StreamedResponse
    {
        $disk = $media->disk ?: 'public';

        abort_unless(
            $media->path &&
            Storage::disk($disk)->exists($media->path),
            404,
            'فایل موردنظر وجود ندارد.'
        );

        $extension = pathinfo(
            $media->path,
            PATHINFO_EXTENSION
        );

        $fileName = $media->alt ?: pathinfo(
            basename($media->path),
            PATHINFO_FILENAME
        );

        $fileName = trim($fileName);

        $downloadName = $extension
            ? $fileName . '.' . $extension
            : $fileName;

        return Storage::disk($disk)->download(
            $media->path,
            $downloadName
        );
    }

}
