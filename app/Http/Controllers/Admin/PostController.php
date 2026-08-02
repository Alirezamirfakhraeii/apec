<?php

namespace App\Http\Controllers\Admin;

use App\Features\Admin\Posts\Actions\CreatePostAction;
use App\Features\Admin\Posts\Actions\UpdatePostAction;
use App\Features\Admin\Posts\DTOs\PostDTO;
use App\Features\Admin\Posts\Queries\GetPostsItemsDataQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Blog\StorePostRequest;
use App\Models\BlogCategory;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class PostController extends Controller
{

    public function index(Request $request, GetPostsItemsDataQuery $query)
    {
        return view('back.admin.posts.index', $query->handle($request));
    }

    public function create(Request $request)
    {
        $categories = BlogCategory::with('children')->get();

        $types = [
            'news' => 'خبر',
            'page' => 'صفحه ثابت',
            'notice' => 'اطلاعیه',
            'report' => 'گزارش',
            'event' => 'رویداد',
            'question' => 'پرسشنامه',
        ];

        $selectedType = $request->get('type', 'news');

        if (! array_key_exists($selectedType, $types)) {
            $selectedType = 'news';
        }

        return view('back.admin.posts.create', compact(
            'categories',
            'types',
            'selectedType'
        ));

    }

    public function store(StorePostRequest $request, CreatePostAction $action): RedirectResponse
    {
        $dto = PostDTO::fromRequest($request);
        $action->execute($dto, auth()->id() ?? 1);
        return redirect()->route('admin.posts.index')->with('success', 'مطلب با موفقیت ثبت شد.');
    }


    public function edit(Post $post)
    {
        $post->load('mainImage');
        $categories = BlogCategory::with('children')->get();
        return view('back.admin.posts.edit', compact('post', 'categories'));
    }

    public function update(StorePostRequest $request, Post $post, UpdatePostAction $action): RedirectResponse
    {
        $dto = PostDTO::fromRequest($request);
        $action->execute($post, $dto);

        return redirect()->route('admin.posts.index')->with('success', 'مطلب با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'مطلب حذف شد.');
    }



    public function upload(Request $request)
    {
        $request->validate([
            'upload' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp,gif',
                'max:5120',
            ],
        ]);

        try {
            $file = $request->file('upload');

            $fileName = Str::uuid()
                . '.'
                . strtolower($file->getClientOriginalExtension());

            $path = $file->storeAs(
                'posts/ckeditor',
                $fileName,
                'public'
            );

            /*
             * خروجی نمونه:
             * https://example.com/storage/posts/ckeditor/image.jpg
             */
            $imageUrl = asset('storage/' . $path);

            return response()->json([
                'uploaded' => true,
                'url'      => $imageUrl,
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json([
                'uploaded' => false,
                'error' => [
                    'message' => 'آپلود تصویر با خطا مواجه شد.',
                ],
            ], 500);
        }
    }


}
