<?php

namespace App\Models;

use App\Enums\ApplicationReviewDecision;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationReview extends Model
{
    protected $fillable = [
        'membership_application_id',
        'reviewer_id',
        'stage_id',
        'decision',
        'comment',
    ];


    protected function casts(): array
    {
        return [
            'decision' => ApplicationReviewDecision::class,
        ];
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(
            MembershipApplication::class,
            'membership_application_id'
        );
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'reviewer_id'
        );
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(
            WorkflowStage::class,
            'stage_id'
        );
    }
}
