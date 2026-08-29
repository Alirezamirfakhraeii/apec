<?php

namespace App\Models;

use App\Enums\MembershipApplicationState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MembershipApplication extends Model
{
    protected $fillable = [
        'user_id',
        'state',
        'current_stage_id',
        'return_stage_id',
        'submitted_at',
        'approved_at',
        'rejected_at',
    ];

    protected function casts(): array
    {
        return [
            'state' => MembershipApplicationState::class,
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function currentStage(): BelongsTo
    {
        return $this->belongsTo(
            WorkflowStage::class,
            'current_stage_id'
        );
    }

    public function returnStage(): BelongsTo
    {
        return $this->belongsTo(
            WorkflowStage::class,
            'return_stage_id'
        );
    }


    public function companyProfile(): HasOne
    {
        return $this->hasOne(
            MembershipCompanyProfile::class,
            'membership_application_id'
        );
    }
}
