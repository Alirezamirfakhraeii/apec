<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyShareholder extends Model
{
    protected $fillable = [
        'company_id',
        'full_name',
        'ownership_percentage',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'ownership_percentage' => 'decimal:2',
            'sort_order' => 'integer',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
