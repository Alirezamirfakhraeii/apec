<?php

namespace App\Http\Controllers\Admin;

use App\Features\Admin\Media\Actions\DeleteMediaAction;
use App\Features\Admin\Media\Actions\DownloadMediaAction;
use App\Features\Admin\Media\Actions\StoreMediaAction;
use App\Features\Admin\Media\Actions\UpdateMediaAction;
use App\Features\Admin\Media\DTOs\StoreMediaData;
use App\Features\Admin\Media\DTOs\UpdateMediaData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Media\StoreMediaRequest;
use App\Http\Requests\Admin\Media\UpdateMediaRequest;
use App\Models\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;


class MediaController extends Controller
{
    public function index(Request $request): View
    {
        $mediaItems = Media::query()
            ->when(
                $request->filled('q'),
                function ($query) use ($request) {
                    $search = trim((string) $request->input('q'));

                    $query->where(function ($query) use ($search) {
                        $query
                            ->where('path', 'like', "%{$search}%")
                            ->orWhere('alt', 'like', "%{$search}%")
                            ->orWhere('caption', 'like', "%{$search}%");
                    });
                }
            )->when(
                $request->filled('type'),
                fn ($query) => $query->where(
                    'type',
                    $request->input('type')
                )
            )
            ->latest('id')
            ->paginate(24)
            ->withQueryString();

        return view('back.admin.media.index', compact('mediaItems'));
    }


    public function store(StoreMediaRequest $request, StoreMediaAction $action,): RedirectResponse {
        $mediaItems = $action->execute(StoreMediaData::fromRequest($request));
        return back()->with('success', "{$mediaItems->count()} فایل با موفقیت آپلود شد."
        );
    }

    public function update(UpdateMediaRequest $request, Media $media, UpdateMediaAction $action,): RedirectResponse {
        $action->execute(media: $media, data: UpdateMediaData::fromRequest($request),
        );
        return back()->with('success', 'اطلاعات رسانه با موفقیت ویرایش شد.');
    }

    public function destroy(Media $media, DeleteMediaAction $action,): RedirectResponse {
        $action->execute($media);
        return back()->with('success', 'رسانه با موفقیت حذف شد.');
    }




}
