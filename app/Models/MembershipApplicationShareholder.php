<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class MembershipApplicationShareholder extends Model
{
    protected $fillable=['membership_application_id','full_name','ownership_percentage','sort_order'];
    protected function casts(): array { return ['ownership_percentage'=>'decimal:2','sort_order'=>'integer']; }
    public function application(): BelongsTo { return $this->belongsTo(MembershipApplication::class,'membership_application_id'); }
}
