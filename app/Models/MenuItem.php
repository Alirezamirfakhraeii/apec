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

    public function getHrefAttribute()
    {
        if ($this->type === 'heading') {
            return '#';
        }

        if ($this->type === 'custom') {
            if (!$this->url) {
                return '#';
            }

            $url = trim($this->url);

            if (Str::startsWith($url, ['http://', 'https://', 'mailto:', 'tel:', '#'])) {
                return $url;
            }

            if (Str::startsWith($url, '/')) {
                return url($url);
            }

            return url('/' . $url);
        }

        if ($this->type === 'route') {
            if (!$this->route_name || !Route::has($this->route_name)) {
                return '#';
            }

            return route($this->route_name, $this->route_params ?? []);
        }

        if (!$this->target) {
            return '#';
        }

        if ($this->type === 'category') {
            if (Route::has('front.categories.show')) {
                return route('front.categories.show', $this->target->slug);
            }

            return url('/category/' . $this->target->slug);
        }

        if ($this->type === 'post') {
            if (Route::has('front.posts.show')) {
                return route('front.posts.show', $this->target->slug);
            }

            return url('/posts/' . $this->target->slug);
        }

        if ($this->type === 'page') {
            if (Route::has('front.pages.show')) {
                return route('front.pages.show', $this->target->slug);
            }

            return url('/pages/' . $this->target->slug);
        }

        return '#';
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
