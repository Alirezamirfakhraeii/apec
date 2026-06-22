<?php

namespace App\Features\Admin\Posts\Actions;

use App\Features\Admin\Posts\DTOs\PostDTO;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;
use Throwable;

class UpdatePostAction
{
    /**
     * @throws Throwable
     */
    public function execute(Post $post, PostDTO $dto): Post
    {
        $newImagePath = null;
        $oldImagePath = null;
        $oldImageDisk = 'public';

        try {
            if ($dto->image) {
                $file = $dto->image;

                $folder = 'posts/original/' . now()->format('Y/m/d');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

                $newImagePath = $file->storeAs($folder, $filename, 'public');
            }

            DB::transaction(function () use ($post, $dto, $newImagePath, &$oldImagePath, &$oldImageDisk) {

                $post->update([
                    'blog_category_id' => $dto->blog_category_id,
                    'title' => $dto->title,
                    'slug' => $this->generateUniqueSlug($dto->title, $post->id),
                    'summary' => $dto->summary,
                    'body' => $dto->body,
                    'meta_title' => $dto->meta_title,
                    'meta_description' => $dto->meta_description,
                    'status' => $dto->status,
                    'published_at' => $this->parseJalaliDate($dto->published_at),

                ]);

                if ($newImagePath && $dto->image) {
                    $file = $dto->image;

                    $oldMainImage = $post->mainImage()->first();

                    if ($oldMainImage) {
                        $oldImagePath = $oldMainImage->path;
                        $oldImageDisk = $oldMainImage->disk ?? 'public';

                        $oldMainImage->delete();
                    }

                    $dimensions = @getimagesize($file->getRealPath());

                    $post->media()->create([
                        'disk' => 'public',
                        'path' => $newImagePath,
                        'type' => 'image',
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize(),
                        'width' => $dimensions[0] ?? null,
                        'height' => $dimensions[1] ?? null,
                        'alt' => $dto->title,
                        'caption' => null,
                        'is_main' => true,
                        'uploaded_by' => auth()->id(),
                    ]);
                }

                if ($dto->tags !== null) {
                    if (method_exists($post, 'syncTags')) {
                        $tagsArray = array_filter(
                            array_map('trim', explode(',', $dto->tags))
                        );

                        $post->syncTags($tagsArray);
                    }
                }
            });

            if ($oldImagePath) {
                Storage::disk($oldImageDisk)->delete($oldImagePath);
            }

            return $post->refresh()->load('mainImage', 'media');

        } catch (Throwable $exception) {
            if ($newImagePath) {
                Storage::disk('public')->delete($newImagePath);
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



    private function generateUniqueSlug(string $title, int $ignorePostId): string
    {
        $baseSlug = Str::slug($title, '-');

        if (! $baseSlug) {
            $baseSlug = Str::random(8);
        }

        $slug = $baseSlug;
        $counter = 2;

        while (
        Post::withoutGlobalScopes()
            ->where('slug', $slug)
            ->where('id', '!=', $ignorePostId)
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
