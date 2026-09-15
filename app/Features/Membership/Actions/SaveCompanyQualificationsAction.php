<?php
namespace App\Features\Membership\Actions;
use App\Enums\MembershipDocumentType;
use App\Features\Membership\Data\CompanyQualificationsData;
use App\Models\MembershipApplication;
use App\Models\MembershipApplicationDocument;
use App\Models\MembershipCompanyProfile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;
final class SaveCompanyQualificationsAction
{
    public function execute(MembershipApplication $application,CompanyQualificationsData $data): MembershipCompanyProfile
    {
        $stored=[];$old=[]; try { $uploads=[MembershipDocumentType::LatestGeneralAssemblyMinutes->value=>$data->latestGeneralAssemblyMinutes,MembershipDocumentType::LatestCapitalGazette->value=>$data->latestCapitalGazette,MembershipDocumentType::OriginalCertificate->value=>$data->originalCertificate,MembershipDocumentType::CompanyResume->value=>$data->companyResume,MembershipDocumentType::ChamberMembershipCard->value=>$data->chamberMembershipCard]; foreach($uploads as $type=>$file){ if(!$file instanceof UploadedFile) continue; $path=$file->store('membership/documents','public'); $stored[$type]=['path'=>$path,'file'=>$file]; } $profile=DB::transaction(function() use($application,$data,$stored,&$old){ $p=MembershipCompanyProfile::query()->firstOrNew(['membership_application_id'=>$application->id]); $p->activity_experience_years=$data->activityExperienceYears; $p->oil_gas_petchem_specialty=$data->oilGasPetchemSpecialty; $p->is_chamber_member=$data->isChamberMember; $p->save(); foreach($stored as $type=>$sf){ $d=MembershipApplicationDocument::query()->firstOrNew(['membership_application_id'=>$application->id,'type'=>$type]); if($d->exists && $d->path) $old[]=$d->path; $file=$sf['file']; $d->fill(['path'=>$sf['path'],'original_name'=>$file->getClientOriginalName(),'mime_type'=>$file->getMimeType(),'size'=>$file->getSize()]); $d->save(); } if(!$data->isChamberMember){ $d=MembershipApplicationDocument::query()->where('membership_application_id',$application->id)->where('type',MembershipDocumentType::ChamberMembershipCard->value)->first(); if($d){ if($d->path) $old[]=$d->path; $d->delete(); } } return $p->fresh(); }); foreach(array_unique($old) as $f) Storage::disk('public')->delete($f); return $profile; } catch(Throwable $e){ foreach($stored as $sf) Storage::disk('public')->delete($sf['path']); throw $e; }
    }
}
