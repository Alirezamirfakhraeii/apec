<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class BlogCategory extends Model
{
    use HasSlug;

    protected $fillable = ['parent_id', 'name', 'slug', 'description' , 'status'];

    // تنظیمات ساخت خودکار اسلاگ بر اساس فیلد Name
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->allowDuplicateSlugs(); // اجازه ساخت اسلاگ‌های مشابه با پسوند عددی
    }


    public function parent(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(BlogCategory::class, 'parent_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'blog_category_id');
    }

}
