<?php

namespace App\Features\Admin\Media\Actions;
use App\Features\Admin\Media\DTOs\UpdateMediaData;
use App\Models\Media;

class UpdateMediaAction
{
    public function execute(
        Media $media,
        UpdateMediaData $data,
    ): Media {
        $media->update($data->toArray());

        return $media->refresh();
    }
}
