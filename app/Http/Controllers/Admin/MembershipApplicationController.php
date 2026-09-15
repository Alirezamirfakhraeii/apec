<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ApplicationReviewDecision;
use App\Enums\MembershipApplicationState;
use App\Features\Membership\Actions\ReviewMembershipApplicationAction;
use App\Features\Membership\Actions\RouteMembershipApplicationAction;
use App\Features\Membership\Actions\UpdateMembershipApplicationAction;
use App\Features\Membership\Actions\UpdateMembershipApplicationStatusAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReviewMembershipApplicationRequest;
use App\Http\Requests\Admin\RouteMembershipApplicationRequest;
use App\Http\Requests\Admin\UpdateMembershipApplicationRequest;
use App\Http\Requests\Admin\UpdateMembershipApplicationStatusRequest;
use App\Models\ActivityField;
use App\Models\MembershipApplication;
use App\Models\WorkflowStage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;


class MembershipApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Access
        |--------------------------------------------------------------------------
        |
        | همه Reviewerها تمام درخواست‌های ارسال‌شده را می‌بینند.
        | اما بررسی/تأیید پرونده همچنان فقط برای Stage مربوط به خودشان است.
        |
        */

        $reviewPermissions = [
            'membership.application.review.it',
            'membership.application.review.secretary',
            'membership.application.review.chair',
            'membership.application.review.board',
        ];

        $isManager =
            $user->hasRole('admin')
            ||
            $user->can('membership.application.manage');

        $isReviewer =
            $user->hasAnyPermission($reviewPermissions);

        if (! $isManager && ! $isReviewer) {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        |
        | Draftها در لیست مدیریت نمایش داده نمی‌شوند.
        |
        */

        $baseQuery = MembershipApplication::query()
            ->where(
                'state',
                '!=',
                MembershipApplicationState::Draft->value
            );


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        |
        | این متغیرها دقیقاً مطابق index.blade.php هستند.
        |
        */

        $totalApplications =
            (clone $baseQuery)
                ->count();


        $inReviewCount =
            (clone $baseQuery)
                ->where(
                    'state',
                    MembershipApplicationState::InReview->value
                )
                ->count();


        $needsCorrectionCount =
            (clone $baseQuery)
                ->where(
                    'state',
                    MembershipApplicationState::NeedsCorrection->value
                )
                ->count();


        $approvedCount =
            (clone $baseQuery)
                ->where(
                    'state',
                    MembershipApplicationState::Approved->value
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Main Query
        |--------------------------------------------------------------------------
        */

        $query = MembershipApplication::query()
            ->with([
                'user',
                'companyProfile',
                'currentStage',
                'returnStage',
            ])
            ->where(
                'state',
                '!=',
                MembershipApplicationState::Draft->value
            );


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        |
        | Blade از q استفاده می‌کند:
        |
        | ?q=...
        |
        */

        if ($request->filled('q')) {

            $search = trim(
                (string) $request->input('q')
            );

            $query->where(
                function ($query) use ($search) {

                    /*
                    |--------------------------------------------------------------------------
                    | Membership Application
                    |--------------------------------------------------------------------------
                    */

                    $query
                        ->where(
                            'intake_company_name',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'representative_name',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'representative_mobile',
                            'like',
                            "%{$search}%"
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | User
                    |--------------------------------------------------------------------------
                    */

                    $query->orWhereHas(
                        'user',
                        function ($userQuery) use ($search) {

                            $userQuery
                                ->where(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                )

                                ->orWhere(
                                    'email',
                                    'like',
                                    "%{$search}%"
                                );

                        }
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Company Profile
                    |--------------------------------------------------------------------------
                    */

                    $query->orWhereHas(
                        'companyProfile',
                        function ($profileQuery) use ($search) {

                            $profileQuery
                                ->where(
                                    'registered_name',
                                    'like',
                                    "%{$search}%"
                                )

                                ->orWhere(
                                    'company_short_name',
                                    'like',
                                    "%{$search}%"
                                )

                                ->orWhere(
                                    'company_name_en',
                                    'like',
                                    "%{$search}%"
                                )

                                ->orWhere(
                                    'registration_number',
                                    'like',
                                    "%{$search}%"
                                )

                                ->orWhere(
                                    'national_id',
                                    'like',
                                    "%{$search}%"
                                );

                        }
                    );

                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | State Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('state')) {

            $allowedStates = collect(
                MembershipApplicationState::cases()
            )
                ->reject(
                    fn (MembershipApplicationState $state) =>
                        $state === MembershipApplicationState::Draft
                )
                ->map(
                    fn (MembershipApplicationState $state) =>
                    $state->value
                )
                ->all();


            $state = (string) $request->input('state');


            if (
                in_array(
                    $state,
                    $allowedStates,
                    true
                )
            ) {
                $query->where(
                    'state',
                    $state
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Stage Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('stage')) {

            $stageId =
                (int) $request->input('stage');

            if ($stageId > 0) {

                $query->where(
                    'current_stage_id',
                    $stageId
                );

            }
        }


        /*
        |--------------------------------------------------------------------------
        | Sort
        |--------------------------------------------------------------------------
        |
        | Blade:
        |
        | latest
        | oldest
        | company_asc
        | company_desc
        |
        */

        $sort = (string) $request->input(
            'sort',
            'latest'
        );


        switch ($sort) {

            /*
            |--------------------------------------------------------------------------
            | Oldest
            |--------------------------------------------------------------------------
            */

            case 'oldest':

                $query
                    ->orderByRaw(
                        'submitted_at IS NULL'
                    )
                    ->orderBy(
                        'submitted_at',
                        'asc'
                    )
                    ->orderBy(
                        'id',
                        'asc'
                    );

                break;


            /*
            |--------------------------------------------------------------------------
            | Company Name ASC
            |--------------------------------------------------------------------------
            */

            case 'company_asc':

                $query
                    ->leftJoin(
                        'membership_company_profiles as membership_profile_sort',
                        'membership_profile_sort.membership_application_id',
                        '=',
                        'membership_applications.id'
                    )

                    ->select(
                        'membership_applications.*'
                    )

                    ->orderByRaw(
                        "
                    COALESCE(
                        membership_profile_sort.registered_name,
                        membership_applications.intake_company_name,
                        ''
                    ) ASC
                    "
                    )

                    ->orderBy(
                        'membership_applications.id',
                        'asc'
                    );

                break;


            /*
            |--------------------------------------------------------------------------
            | Company Name DESC
            |--------------------------------------------------------------------------
            */

            case 'company_desc':

                $query
                    ->leftJoin(
                        'membership_company_profiles as membership_profile_sort',
                        'membership_profile_sort.membership_application_id',
                        '=',
                        'membership_applications.id'
                    )

                    ->select(
                        'membership_applications.*'
                    )

                    ->orderByRaw(
                        "
                    COALESCE(
                        membership_profile_sort.registered_name,
                        membership_applications.intake_company_name,
                        ''
                    ) DESC
                    "
                    )

                    ->orderBy(
                        'membership_applications.id',
                        'desc'
                    );

                break;


            /*
            |--------------------------------------------------------------------------
            | Latest
            |--------------------------------------------------------------------------
            */

            case 'latest':

            default:

                $query
                    ->orderByRaw(
                        'submitted_at IS NULL'
                    )
                    ->orderBy(
                        'submitted_at',
                        'desc'
                    )
                    ->orderBy(
                        'id',
                        'desc'
                    );

                break;
        }


        /*
        |--------------------------------------------------------------------------
        | Per Page
        |--------------------------------------------------------------------------
        |
        | Blade به صورت پیش‌فرض 10 دارد.
        |
        */

        $allowedPerPages = [
            10,
            20,
            50,
            100,
        ];


        $perPage = (int) $request->input(
            'per_page',
            10
        );


        if (
            ! in_array(
                $perPage,
                $allowedPerPages,
                true
            )
        ) {
            $perPage = 10;
        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $applications = $query
            ->paginate($perPage)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Workflow Stages
        |--------------------------------------------------------------------------
        |
        | همه Stageهای فعال برای Filter نمایش داده می‌شوند.
        |
        */

        $workflowStages = WorkflowStage::query()
            ->where(
                'is_active',
                true
            )
            ->orderBy(
                'position',
                'asc'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'back.admin.membership-applications.index',
            compact(
                'applications',
                'workflowStages',
                'totalApplications',
                'inReviewCount',
                'needsCorrectionCount',
                'approvedCount'
            )
        );
    }


    public function show(
        MembershipApplication $application
    ): View {
        /*
        |--------------------------------------------------------------------------
        | Load Application Relations
        |--------------------------------------------------------------------------
        */

        $application->load([
            'user',
            'company',
            'companyProfile',
            'shareholders',
            'documents',
            'activityFields',
            'currentStage',
            'returnStage',
            'reviews.stage',
            'reviews.reviewer',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        Gate::authorize(
            'view',
            $application
        );


        /*
        |--------------------------------------------------------------------------
        | Workflow Stages
        |--------------------------------------------------------------------------
        |
        | برای بخش مدیریت گردش پرونده در show.blade.php
        |
        */

        $workflowStages = WorkflowStage::query()
            ->active()
            ->ordered()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'back.admin.membership-applications.show',
            compact(
                'application',
                'workflowStages'
            )
        );
    }


    public function routeToStage(
        RouteMembershipApplicationRequest $request,
        MembershipApplication             $application,
        RouteMembershipApplicationAction  $action
    ): RedirectResponse
    {
        $targetStage = WorkflowStage::query()
            ->whereKey(
                $request->validated('stage_id')
            )
            ->where('is_active', true)
            ->firstOrFail();

        $action->execute(
            application: $application,
            targetStage: $targetStage,
            actor: $request->user(),
            comment: $request->validated('comment'),
        );

        return redirect()
            ->route(
                'admin.membership-applications.show',
                $application
            )
            ->with(
                'success',
                'پرونده با موفقیت به «' .
                $targetStage->name .
                '» ارجاع شد.'
            );
    }

    public function updateStatus(
        UpdateMembershipApplicationStatusRequest $request,
        MembershipApplication $application,
        UpdateMembershipApplicationStatusAction $action
    ): RedirectResponse {
        $data = $request->validated();

        $newState = MembershipApplicationState::from(
            $data['state']
        );

        $stage = null;

        if (! empty($data['stage_id'])) {
            $stage = WorkflowStage::query()
                ->whereKey($data['stage_id'])
                ->where('is_active', true)
                ->firstOrFail();
        }

        $action->execute(
            application: $application,
            newState: $newState,
            actor: $request->user(),
            stage: $stage,
            comment: $data['comment'],
        );

        return redirect()
            ->route(
                'admin.membership-applications.show',
                $application
            )
            ->with(
                'success',
                'وضعیت پرونده با موفقیت اصلاح شد.'
            );
    }


    public function edit(
        MembershipApplication $application
    ): View {
        $application->load([
            'user',
            'companyProfile',
            'shareholders',
            'documents',
            'activityFields',
            'currentStage',
            'returnStage',
        ]);

        Gate::authorize(
            'update',
            $application
        );

        $activityFields = ActivityField::query()
            ->where('is_active', true)
            ->orderBy('section')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->groupBy(
                fn (ActivityField $field) =>
                $field->section ?: 'سایر'
            );

        return view(
            'back.admin.membership-applications.edit',
            compact(
                'application',
                'activityFields'
            )
        );
    }



    public function update(
        UpdateMembershipApplicationRequest $request,
        MembershipApplication $application,
        UpdateMembershipApplicationAction $action
    ) {
        $data = $request->validated();

        $data['shareholders'] = $request->input(
            'shareholders',
            []
        );

        $data['activity_fields'] = $request->input(
            'activity_fields',
            []
        );

        try {
            $action->execute(
                $application,
                $data,
                $request->user()
            );

            return redirect()
                ->route(
                    'admin.membership-applications.show',
                    $application
                )
                ->with(
                    'success',
                    'اطلاعات پرونده با موفقیت بروزرسانی شد.'
                );

        } catch (\Illuminate\Validation\ValidationException $e) {

            throw $e;

        } catch (\Throwable $e) {

            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'خطایی در بروزرسانی پرونده رخ داد.'
                );
        }
    }


    public function review(
        ReviewMembershipApplicationRequest $request,
        MembershipApplication $application,
        ReviewMembershipApplicationAction $action
    ): RedirectResponse {
        $validated = $request->validated();

        $decision = ApplicationReviewDecision::from(
            $validated['decision']
        );

        try {
            $result = $action->execute(
                application: $application,
                decision: $decision,
                actor: $request->user(),
                comment: $validated['comment'] ?? null,
            );

            $message = match ($decision) {
                ApplicationReviewDecision::Approved =>
                $result->state ===
                \App\Enums\MembershipApplicationState::Approved
                    ? 'درخواست عضویت با موفقیت تأیید نهایی شد.'
                    : 'پرونده تأیید و به مرحله بعد ارسال شد.',

                ApplicationReviewDecision::NeedsCorrection =>
                'پرونده برای اصلاح به متقاضی بازگردانده شد.',

                ApplicationReviewDecision::Rejected =>
                'درخواست عضویت رد شد.',

                default =>
                'تصمیم بررسی با موفقیت ثبت شد.',
            };

            return redirect()
                ->route(
                    'admin.membership-applications.show',
                    $application
                )
                ->with(
                    'success',
                    $message
                );

        } catch (ValidationException $e) {

            throw $e;

        } catch (AuthorizationException $e) {

            throw $e;

        } catch (Throwable $e) {

            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'در ثبت نتیجه بررسی پرونده خطایی رخ داد.'
                );
        }
    }




}
