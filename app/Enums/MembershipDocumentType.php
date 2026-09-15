<?php
namespace App\Enums;
enum MembershipDocumentType: string
{
    case OfficialGazette='official_gazette';
    case LatestGeneralAssemblyMinutes='latest_general_assembly_minutes';
    case LatestCapitalGazette='latest_capital_gazette';
    case OriginalCertificate='original_certificate';
    case CompanyResume='company_resume';
    case ChamberMembershipCard='chamber_membership_card';
    public function label(): string
    {
        return match($this){
            self::OfficialGazette=>'روزنامه رسمی',
            self::LatestGeneralAssemblyMinutes=>'آخرین صورتجلسه مجمع عمومی',
            self::LatestCapitalGazette=>'روزنامه رسمی آخرین میزان سرمایه',
            self::OriginalCertificate=>'اصل گواهینامه',
            self::CompanyResume=>'رزومه شرکت',
            self::ChamberMembershipCard=>'کارت عضویت اتاق بازرگانی',
        };
    }
}
