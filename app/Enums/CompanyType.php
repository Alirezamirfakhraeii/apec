<?php
namespace App\Enums;
enum CompanyType: string
{
    case PrivateJointStock='private_joint_stock';
    case PublicJointStock='public_joint_stock';
    case LimitedLiability='limited_liability';
    case Cooperative='cooperative';
    case Other='other';
    public function label(): string
    {
        return match($this){
            self::PrivateJointStock=>'سهامی خاص', self::PublicJointStock=>'سهامی عام',
            self::LimitedLiability=>'با مسئولیت محدود', self::Cooperative=>'تعاونی', self::Other=>'سایر',
        };
    }
    public static function options(): array
    {
        return array_map(fn(self $t)=>['value'=>$t->value,'label'=>$t->label()], self::cases());
    }
}
