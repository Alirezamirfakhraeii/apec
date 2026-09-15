<?php
namespace App\Features\Membership\Actions;
use App\Enums\MembershipApplicationState;
use App\Features\Membership\Data\MembershipIntakeData;
use App\Models\MembershipApplication;
use App\Models\User;
use Illuminate\Support\Facades\DB;
final class StartMembershipApplicationAction
{
    public function execute(User $user,MembershipIntakeData $data): MembershipApplication
    {
        return DB::transaction(function() use($user,$data){ User::query()->whereKey($user->id)->lockForUpdate()->firstOrFail(); $a=MembershipApplication::query()->where('user_id',$user->id)->where('state',MembershipApplicationState::Draft->value)->latest('id')->first(); if(!$a) $a=MembershipApplication::create(['user_id'=>$user->id,'state'=>MembershipApplicationState::Draft]); $a->update(['intake_company_name'=>$data->companyName,'representative_name'=>$data->representativeName,'representative_mobile'=>$data->representativeMobile,'intake_confirmed_at'=>now()]); return $a->fresh(); });
    }
}
