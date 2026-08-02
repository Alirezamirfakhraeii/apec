<?php

namespace App\Http\Controllers\Front;

use App\Features\Admin\Media\Actions\DownloadMediaAction;
use App\Http\Controllers\Controller;
use App\Models\Media;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MediaDownloadController extends Controller
{

    public function download(Media $media, DownloadMediaAction $action): StreamedResponse {
        return $action->execute($media);
    }


}
