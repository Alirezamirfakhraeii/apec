<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    protected $fillable = [
        'disk',
        'path',
        'url',
        'type',
        'mime_type',
        'size',
        'width',
        'height',
        'alt',
        'caption',
        'is_main',
        'uploaded_by',
    ];

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}
