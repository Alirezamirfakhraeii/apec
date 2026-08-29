<?php

namespace App\Enums;

enum MembershipApplicationState: string
{
    case Draft = 'draft';

    case Submitted = 'submitted';

    case InReview = 'in_review';

    case NeedsCorrection = 'needs_correction';

    case Rejected = 'rejected';

    case Approved = 'approved';
}
