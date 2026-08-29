<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembershipCompanyProfile extends Model
{
    protected $fillable = [
        'membership_application_id',

        'logo_path',

        'company_short_name',
        'registered_name',
        'company_name_en',
        'nationality',
        'parent_company_name',
        'company_type',

        'registration_date',
        'registration_number',
        'registration_place',
        'national_id',
        'registered_capital_irr',
        'reference_gazette_date',

        'phone',
        'fax',
        'email',
        'website',
        'address',

        'ceo_name',
        'ceo_mobile',
        'ceo_email',

        'chairman_name',
        'chairman_mobile',
        'chairman_email',

        'association_contact_name',
        'association_contact_position',
        'association_contact_mobile',
        'association_contact_email',

        'has_valid_commercial_card',
        'commercial_card_valid_until',

        'has_valid_chamber_membership_card',
        'chamber_membership_valid_until',
        'chamber_province',

        'activity_design_consulting',
        'activity_construction_installation',
        'activity_epc',
        'activity_mc',
        'activity_manufacturing',
        'activity_type',

        'membership_type',
        'association_committees',
    ];

    protected function casts(): array
    {
        return [
            'registration_date' => 'date',
            'reference_gazette_date' => 'date',

            'registered_capital_irr' => 'decimal:0',

            'has_valid_commercial_card' => 'boolean',
            'commercial_card_valid_until' => 'date',

            'has_valid_chamber_membership_card' => 'boolean',
            'chamber_membership_valid_until' => 'date',

            'activity_design_consulting' => 'boolean',
            'activity_construction_installation' => 'boolean',
            'activity_epc' => 'boolean',
            'activity_mc' => 'boolean',
            'activity_manufacturing' => 'boolean',
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(
            MembershipApplication::class,
            'membership_application_id'
        );
    }
}
