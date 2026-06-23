<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Podcast extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'host_name',
        'summary',
        'image',
        'audio_url',
        'duration',
        'embed_code',
        'castbox_url',
        'spotify_url',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getCoverImageUrlAttribute(): string
    {
        if (! empty($this->image)) {
            if (Str::startsWith($this->image, ['http://', 'https://'])) {
                return $this->image;
            }

            if (Str::startsWith($this->image, '/storage/')) {
                return asset(ltrim($this->image, '/'));
            }

            if (Str::startsWith($this->image, 'storage/')) {
                return asset($this->image);
            }

            return asset('storage/' . ltrim($this->image, '/'));
        }

        return asset('front/img/default-podcast.jpg');
    }
}
