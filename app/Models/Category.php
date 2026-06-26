<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->hasMany(Category::class, 'parent_id')
            ->with('children')
            ->orderBy('position', 'asc');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }











}
