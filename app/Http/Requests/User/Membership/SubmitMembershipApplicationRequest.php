<?php
namespace App\Http\Requests\User\Membership;
use App\Models\MembershipApplication;
use Illuminate\Foundation\Http\FormRequest;
class SubmitMembershipApplicationRequest extends FormRequest
{
    public function authorize(): bool { $a=$this->route('application'); return $a instanceof MembershipApplication && $this->user()!==null && $a->user_id===$this->user()->id && $a->isEditable(); }
    public function rules(): array { return []; }
}
