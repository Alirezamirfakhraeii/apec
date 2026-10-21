<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserUpload extends Model
{
    protected $fillable = [
        'file_path',
        'original_name',
        'mime_type',
        'file_size',
    ];

}
