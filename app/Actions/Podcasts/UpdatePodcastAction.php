<?php

namespace App\Actions\Podcasts;

use App\Models\Category;
use App\Models\Podcast;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UpdatePodcastAction
{
    /**
     * @throws ValidationException
     */
    public function execute(Podcast $podcast, array $data): Podcast
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

        $data['slug'] = $this->generateUniqueSlug($data['title'], $podcast->id);

        $status = $data['status'] ?? $podcast->status;

        if ($status === 'published' && ! $podcast->published_at) {
            $data['published_at'] = now();
        }

        if ($status === 'draft') {
            $data['published_at'] = null;
        }

        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            if ($podcast->image) {
                Storage::disk('public')->delete($podcast->image);
            }

            $data['image'] = $data['image']->store('podcasts/images', 'public');
        } else {
            unset($data['image']);
        }

        if (isset($data['audio_file']) && $data['audio_file'] instanceof UploadedFile) {
            if ($podcast->audio_url) {
                Storage::disk('public')->delete($podcast->audio_url);
            }

            $data['audio_url'] = $data['audio_file']->store('podcasts/audio', 'public');

            unset($data['audio_file']);
        }

        if (isset($data['audio_url']) && $data['audio_url'] instanceof UploadedFile) {
            if ($podcast->audio_url) {
                Storage::disk('public')->delete($podcast->audio_url);
            }

            $data['audio_url'] = $data['audio_url']->store('podcasts/audio', 'public');
        }

        $podcast->update($data);

        return $podcast->refresh();
    }

    private function generateUniqueSlug(string $title, int $ignorePodcastId): string
    {
        $baseSlug = Str::slug($title, '-');

        if (! $baseSlug) {
            $baseSlug = Str::random(8);
        }

        $slug = $baseSlug;
        $counter = 2;

        while (
        Podcast::where('slug', $slug)
            ->where('id', '!=', $ignorePodcastId)
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
