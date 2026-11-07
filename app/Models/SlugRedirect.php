<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SlugRedirect extends Model
{
    protected $fillable = [
        'route_name',
        'redirectable_type',
        'redirectable_id',
        'old_slug',
    ];


    // محتوای مقصد ریدایرکت
    public function redirectable(): MorphTo
    {
        return $this->morphTo();
    }
}
