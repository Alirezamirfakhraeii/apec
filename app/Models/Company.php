<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
