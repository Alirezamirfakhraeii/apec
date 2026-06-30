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
        if ($this->type === self::TYPE_HEADING) {
            return '#';
        }

        if ($this->type === self::TYPE_ROUTE) {
            if (!$this->route_name || !Route::has($this->route_name)) {
                return '#';
            }

            return route($this->route_name, $this->route_params ?? []);
        }

        // مهم‌ترین بخش:
        // برای custom/page/category/post اگر url داری، همون باید لینک اصلی باشه
        if (!empty($this->url)) {
            return $this->normalizeUrl($this->url);
        }

        if (!$this->target) {
            return '#';
        }

        if ($this->type === self::TYPE_PAGE) {
            return url('/' . $this->target->slug);
        }

        if ($this->type === self::TYPE_CATEGORY) {
            return url('/' . $this->target->slug);
        }

        if ($this->type === self::TYPE_POST) {
            return route('front.posts.show', $this->target->slug);
        }

        if ($this->type === self::TYPE_CUSTOM) {
            return $this->normalizeUrl($this->url);
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
