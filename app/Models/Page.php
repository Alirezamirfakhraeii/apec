<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'template',
        'template_data',
        'body',
        'meta_title',
        'meta_description',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'template_data' => 'array',
        'published_at' => 'datetime',
    ];


    public function target()
    {
        return $this->morphTo();
    }

}
