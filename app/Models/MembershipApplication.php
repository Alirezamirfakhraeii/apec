<?php

namespace App\Models;

use App\Enums\MembershipApplicationState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MembershipApplication extends Model
{
    protected $fillable = ['user_id', 'company_id', 'intake_company_name', 'representative_name', 'representative_mobile', 'intake_confirmed_at', 'state', 'current_stage_id', 'return_stage_id', 'submitted_at', 'approved_at', 'rejected_at'];

    protected function casts(): array
    {
        return ['state' => MembershipApplicationState::class, 'intake_confirmed_at' => 'datetime', 'submitted_at' => 'datetime', 'approved_at' => 'datetime', 'rejected_at' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function companyProfile(): HasOne
    {
        return $this->hasOne(MembershipCompanyProfile::class, 'membership_application_id');
    }

    public function shareholders(): HasMany
    {
        return $this->hasMany(MembershipApplicationShareholder::class, 'membership_application_id')->orderBy('sort_order');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(MembershipApplicationDocument::class, 'membership_application_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ApplicationReview::class, 'membership_application_id')->latest('id');
    }

    public function currentStage(): BelongsTo
    {
        return $this->belongsTo(WorkflowStage::class, 'current_stage_id');
    }

    public function returnStage(): BelongsTo
    {
        return $this->belongsTo(WorkflowStage::class, 'return_stage_id');
    }

    public function isEditable(): bool
    {
        return in_array($this->state, [MembershipApplicationState::Draft, MembershipApplicationState::NeedsCorrection], true);
    }

    public function isDraft(): bool
    {
        return $this->state === MembershipApplicationState::Draft;
    }

    public function isInReview(): bool
    {
        return $this->state === MembershipApplicationState::InReview;
    }

    public function isApproved(): bool
    {
        return $this->state === MembershipApplicationState::Approved;
    }

    public function isRejected(): bool
    {
        return $this->state === MembershipApplicationState::Rejected;
    }

    public function activityFields(): BelongsToMany
    {
        return $this->belongsToMany(
            ActivityField::class,
            'membership_application_activity_field',
            'membership_application_id',
            'activity_field_id'
        )->withTimestamps();
    }

}
