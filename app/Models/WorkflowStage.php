<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class WorkflowStage extends Model
{
    protected $fillable = [
        'name',
        'code',
        'position',
        'required_permission',
        'is_final',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'position' => 'integer',
            'is_final' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('position');
    }
}
