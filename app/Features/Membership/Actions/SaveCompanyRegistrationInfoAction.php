<?php
namespace App\Features\Membership\Actions;
use App\Enums\MembershipDocumentType;
use App\Features\Membership\Data\CompanyRegistrationInfoData;
use App\Models\MembershipApplication;
use App\Models\MembershipApplicationDocument;
use App\Models\MembershipCompanyProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;
final class SaveCompanyRegistrationInfoAction
{
    public function execute(MembershipApplication $application,CompanyRegistrationInfoData $data): MembershipCompanyProfile
    {
        $new=null;$old=null; try { if($data->officialGazette) $new=$data->officialGazette->store('membership/documents','public'); $profile=DB::transaction(function() use($application,$data,$new,&$old){ $p=MembershipCompanyProfile::query()->firstOrNew(['membership_application_id'=>$application->id]); $p->registration_date=$data->registrationDate; $p->registration_number=$data->registrationNumber; $p->registration_place=$data->registrationPlace; $p->registered_capital_irr=$data->registeredCapitalIrr; $p->reference_gazette_date=$data->referenceGazetteDate; $p->save(); $application->shareholders()->delete(); foreach($data->shareholders as $i=>$s) $application->shareholders()->create(['full_name'=>$s['full_name'],'ownership_percentage'=>$s['ownership_percentage'],'sort_order'=>$i]); if($data->officialGazette && $new){ $d=MembershipApplicationDocument::query()->firstOrNew(['membership_application_id'=>$application->id,'type'=>MembershipDocumentType::OfficialGazette->value]); $old=$d->path; $d->fill(['path'=>$new,'original_name'=>$data->officialGazette->getClientOriginalName(),'mime_type'=>$data->officialGazette->getMimeType(),'size'=>$data->officialGazette->getSize()]); $d->save(); } return $p->fresh(); }); if($old && $old!==$new) Storage::disk('public')->delete($old); return $profile; } catch(Throwable $e){ if($new) Storage::disk('public')->delete($new); throw $e; }
    }
}
