<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'registered_capital_irr' => 'decimal:0',

        'has_valid_commercial_card' => 'boolean',
        'has_valid_chamber_membership_card' => 'boolean',

        'activity_design_consulting' => 'boolean',
        'activity_construction_installation' => 'boolean',
        'activity_epc' => 'boolean',

        'activity_mc' => 'boolean',
        'activity_manufacturing' => 'boolean',
    ];


    public function getLogoUrlAttribute(): ?string
    {
        if (! $this->logo) {
            return null;
        }

        return Storage::disk('public')->url($this->logo);
    }

    public function activityFields(): BelongsToMany
    {
        return $this->belongsToMany(
            ActivityField::class,
            'company_activity_field',
            'company_id',
            'activity_field_id'
        );
    }


    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }


}
