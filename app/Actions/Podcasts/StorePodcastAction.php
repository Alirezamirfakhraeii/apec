<?php

namespace App\Actions\Podcasts;

use App\Models\Category;
use App\Models\Podcast;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class StorePodcastAction
{
    /**
     * @throws ValidationException
     */
    public function execute(array $data): Podcast
    {
        if (! empty($data['category_id'])) {
            $categoryExists = Category::where('id', $data['category_id'])
                ->where('type', 'podcast')
                ->exists();

            if (! $categoryExists) {
                throw ValidationException::withMessages([
                    'category_id' => 'دسته‌بندی انتخاب‌شده مخصوص پادکست نیست.',
                ]);
            }
        }

        $data['slug'] = $this->generateUniqueSlug($data['title']);

        $data['published_at'] = ($data['status'] ?? '') === 'published'
            ? now()
            : null;

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $data['image']->store('podcasts/images', 'public');
        }

        if (isset($data['audio_file']) && $data['audio_file'] instanceof UploadedFile) {
            $data['audio_url'] = $data['audio_file']->store('podcasts/audio', 'public');

            unset($data['audio_file']);
        }

        return Podcast::create($data);
    }

    private function generateUniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title, '-');

        if (! $baseSlug) {
            $baseSlug = Str::random(8);
        }

        $slug = $baseSlug;
        $counter = 2;

        while (Podcast::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
