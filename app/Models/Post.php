<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

class Post extends Model
{
    use HasSlug, HasTags;

    protected $fillable = [
        'user_id',
        'blog_category_id',
        'title',
        'slug',
        'image',
        'body',
        'summary',
        'meta_title',
        'meta_description',
        'status',
        'view_count',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->allowDuplicateSlugs();
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function mainImage(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')
            ->where('is_main', true);
    }


    public function getMainImageUrlAttribute(): string
    {
        $image = $this->relationLoaded('mainImage')
            ? $this->mainImage
            : $this->mainImage()->first();

        if (! $image || ! $image->path) {
            return asset('front/img/default.jpg');
        }

        return asset('storage/' . $image->path);
    }

}
