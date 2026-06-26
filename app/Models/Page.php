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
        'status',
    ];

    protected $casts = [
        'route_params' => 'array',
        'status' => 'boolean',
        'open_in_new_tab' => 'boolean',
    ];

    public function target()
    {
        return $this->morphTo();
    }


}
