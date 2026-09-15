<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class WorkflowStage extends Model
{
    protected $fillable=['name','code','position','required_permission','is_final','is_active'];
    protected function casts(): array { return ['position'=>'integer','is_final'=>'boolean','is_active'=>'boolean']; }
    public function reviews(): HasMany { return $this->hasMany(ApplicationReview::class,'stage_id'); }
    public function currentApplications(): HasMany { return $this->hasMany(MembershipApplication::class,'current_stage_id'); }
    public function returnedApplications(): HasMany { return $this->hasMany(MembershipApplication::class,'return_stage_id'); }
    public function scopeActive($query){ return $query->where('is_active',true); }
    public function scopeOrdered($query){ return $query->orderBy('position'); }
}
