<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPage extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'phone',
        'mobile',
        'email',
        'address',
        'body',
        'map_link',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
