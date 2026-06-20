<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Auth\Admin\Posts\CreatePostAction;
use App\Actions\Auth\Admin\Posts\UpdatePostAction;
use App\DTOs\Auth\Admin\Posts\PostDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Blog\StorePostRequest;
use App\Models\BlogCategory;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::with('mainImage', 'author')->latest()->paginate(15);
        return view('back.admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = BlogCategory::with('children')->get();
        return view('back.admin.posts.create', compact('categories'));
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


}
