<?php

namespace App\Enums;

enum ApplicationReviewDecision: string
{
    case Approved = 'approved';

    case Rejected = 'rejected';

    case NeedsCorrection = 'needs_correction';
}
