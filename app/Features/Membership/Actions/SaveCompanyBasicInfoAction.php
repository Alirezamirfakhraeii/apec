<?php
namespace App\Features\Membership\Actions;
use App\Features\Membership\Data\CompanyBasicInfoData;
use App\Models\MembershipApplication;
use App\Models\MembershipCompanyProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;
final class SaveCompanyBasicInfoAction
{
    public function execute(MembershipApplication $application,CompanyBasicInfoData $data): MembershipCompanyProfile
    {
        $new=null; try { if($data->logo) $new=$data->logo->store('membership/company-logos','public'); $old=null; $profile=DB::transaction(function() use($application,$data,$new,&$old){ $p=MembershipCompanyProfile::query()->firstOrNew(['membership_application_id'=>$application->id]); if($new){$old=$p->logo_path;$p->logo_path=$new;} $p->company_short_name=$data->companyShortName; $p->registered_name=$data->registeredName; $p->company_name_en=$data->companyNameEn; $p->nationality=$data->nationality; $p->company_type=$data->companyType; $p->parent_company_name=$data->parentCompanyName; $p->save(); return $p->fresh(); }); if($old && $old!==$new) Storage::disk('public')->delete($old); return $profile; } catch(Throwable $e){ if($new) Storage::disk('public')->delete($new); throw $e; }
    }
}
