<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{

    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'type',
        'parent_id',
        'status',
        'position'
    ];


    public function children()
    {
        // 🌟 حتماً باید orderBy('position', 'asc') در انتهای رابطه اضافه شده باشه
        return $this->hasMany(Category::class, 'parent_id')
            ->with('children')
            ->orderBy('position', 'asc');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }











}
