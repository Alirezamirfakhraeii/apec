<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardMember extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'roles',
        'email',
        'phone',
        'fax',
        'address',
        'postal_code',
        'image',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'roles' => 'array',
        'is_active' => 'boolean',
    ];
}
