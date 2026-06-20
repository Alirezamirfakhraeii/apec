<?php

namespace App\Actions\Auth\Admin\Posts;

use App\DTOs\Auth\Admin\Posts\PostDTO;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;
use Throwable;

class CreatePostAction
{
    /**
     * @throws Throwable
     */
    public function execute(PostDTO $dto, int $userId): Post
    {
        $imagePath = null;

        try {
            return DB::transaction(function () use ($dto, $userId, &$imagePath) {

                $post = Post::create([
                    'blog_category_id' => $dto->blog_category_id,
                    'user_id' => $userId,
                    'title' => $dto->title,
                    'slug' => $this->generateUniqueSlug($dto->title),
                    'summary' => $dto->summary,
                    'body' => $dto->body,
                    'image' => $dto->image ?? "-",
                    'meta_title' => $dto->meta_title,
                    'meta_description' => $dto->meta_description,
                    'status' => $dto->status,
                    'published_at' => $this->parseJalaliDate($dto->published_at),
                ]);

                if ($dto->image) {
                    $file = $dto->image;

                    $folder = 'posts/original/' . now()->format('Y/m/d');
                    $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

                    $imagePath = $file->storeAs($folder, $filename, 'public');

                    [$width, $height] = getimagesize($file->getRealPath()) ?: [null, null];

                    $post->media()->create([
                        'disk' => 'public',
                        'path' => $imagePath,
                        'type' => 'image',
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize(),
                        'width' => $width,
                        'height' => $height,
                        'alt' => $dto->title,
                        'caption' => null,
                        'is_main' => true,
                        'uploaded_by' => $userId,
                    ]);
                }
                return $post->load('mainImage');
            });
        } catch (Throwable $exception) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            throw $exception;
        }
    }

    private function parseJalaliDate($date)
    {
        if (!$date) return null;

        $date = str_replace(
            ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'],
            ['0','1','2','3','4','5','6','7','8','9'],
            $date
        );

        try {
            return Jalalian::fromFormat('Y/m/d H:i', $date)->toCarbon();
        } catch (\Throwable $e) {
            return null;
        }
    }


    private function generateUniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title, '-');

        if (! $baseSlug) {
            $baseSlug = Str::random(8);
        }

        $slug = $baseSlug;
        $counter = 2;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
