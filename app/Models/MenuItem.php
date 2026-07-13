<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class MenuItem extends Model
{
    use HasFactory;

    public const TYPE_CUSTOM = 'custom';
    public const TYPE_ROUTE = 'route';
    public const TYPE_HEADING = 'heading';
    public const TYPE_CATEGORY = 'category';
    public const TYPE_PAGE = 'page';
    public const TYPE_POST = 'post';

    protected $fillable = [
        'title',
        'type',
        'url',

        'target_type',
        'target_id',

        'route_name',
        'route_params',

        'icon',
        'parent_id',
        'status',
        'position',
        'open_in_new_tab',
    ];

    protected $casts = [
        'status' => 'boolean',
        'open_in_new_tab' => 'boolean',
        'route_params' => 'array',
    ];

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->with('children')
            ->orderBy('position', 'asc');
    }

    public function activeChildren()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->with(['target', 'activeChildren'])
            ->where('status', 1)
            ->orderBy('position', 'asc');
    }

    public function target()
    {
        return $this->morphTo();
    }

    public function getHrefAttribute(): string
    {
        return match ($this->type) {
            'page' => $this->pageHref(),

            'category' => $this->categoryHref(),

            'post' => $this->postHref(),

            'route' => $this->routeHref(),

            'custom' => $this->customHref(),

            'heading' => '#',

            default => '#',
        };
    }

    private function pageHref(): string
    {
        if (!$this->target instanceof \App\Models\Page) {
            return '#';
        }

        return route('front.pages.show', [
            'slug' => $this->target->slug,
        ]);
    }

    private function categoryHref(): string
    {
        if (!$this->target instanceof \App\Models\Category) {
            return '#';
        }

        return route('front.categories.show', [
            'slug' => $this->target->slug,
        ]);
    }

    private function postHref(): string
    {
        if (!$this->target instanceof \App\Models\Post) {
            return '#';
        }

        return route('front.posts.show', [
            'slug' => $this->target->slug,
        ]);
    }

    private function routeHref(): string
    {
        if (!$this->route_name || !\Illuminate\Support\Facades\Route::has($this->route_name)) {
            return '#';
        }

        return route(
            $this->route_name,
            $this->route_params ?? []
        );
    }

    private function customHref(): string
    {
        if (!$this->url) {
            return '#';
        }

        if (
            str_starts_with($this->url, 'http://') ||
            str_starts_with($this->url, 'https://') ||
            str_starts_with($this->url, '//')
        ) {
            return $this->url;
        }

        return url('/' . ltrim($this->url, '/'));
    }

    public function getIsLinkableAttribute()
    {
        return $this->type !== self::TYPE_HEADING;
    }

    private function normalizeUrl($url)
    {
        if (!$url) {
            return '#';
        }

        $url = trim($url);

        if (Str::startsWith($url, ['http://', 'https://', 'mailto:', 'tel:', '#'])) {
            return $url;
        }

        if (Str::startsWith($url, '/')) {
            return url($url);
        }

        return url('/' . $url);
    }


}
