<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\UserUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserUploadController extends Controller
{
    public function index(): View
    {
        return view('front.upload.index');
    }


    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'file' => [
                'required',
                'file',
                'max:5120',
            ],
        ], [
            'file.required' => 'لطفاً فایل را انتخاب کنید.',
            'file.file' => 'فایل انتخاب‌شده معتبر نیست.',
            'file.max' => 'حداکثر حجم فایل ۵ مگابایت است.',
        ]);

        $file = $validated['file'];

        $path = $file->store(
            'user-uploads',
            'local'
        );

        UserUpload::create([
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);

        return back()->with(
            'success',
            'فایل با موفقیت ارسال شد.'
        );
    }
}
