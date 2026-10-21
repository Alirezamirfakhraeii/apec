<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\UserUpload;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;


class UserUploadController extends Controller
{
    public function index(): View
    {
        $uploads = UserUpload::query()
            ->with('user')
            ->latest()
            ->paginate(20);

        return view(
            'back.admin.user-uploads.index',
            compact('uploads')
        );
    }

    public function download(
        UserUpload $userUpload
    ): StreamedResponse {
        abort_unless(
            Storage::disk('local')
                ->exists($userUpload->file_path),
            404
        );

        return Storage::disk('local')->download(
            $userUpload->file_path,
            $userUpload->original_name
        );
    }
}
