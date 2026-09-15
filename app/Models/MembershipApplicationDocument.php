<?php
namespace App\Models;
use App\Enums\MembershipDocumentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class MembershipApplicationDocument extends Model
{
    protected $fillable=['membership_application_id','type','path','original_name','mime_type','size'];
    protected function casts(): array { return ['type'=>MembershipDocumentType::class,'size'=>'integer']; }
    public function application(): BelongsTo { return $this->belongsTo(MembershipApplication::class,'membership_application_id'); }
}
