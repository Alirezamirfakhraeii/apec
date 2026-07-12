<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'body',
        'meta_title',
        'meta_description',
        'template',
        'status',
        'template_data',
    ];

    protected $casts = [
        'status' => 'boolean',
        'template_data' => 'array',
    ];

    public function target()
    {
        return $this->morphTo();
    }

}
