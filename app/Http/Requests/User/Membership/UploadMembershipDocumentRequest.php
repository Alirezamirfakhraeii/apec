<?php

namespace App\Http\Requests\User\Membership;

use App\Enums\MembershipDocumentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadMembershipDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('application')) ?? false;
    }

    public function rules(): array
    {
        $type = MembershipDocumentType::tryFrom((string) $this->input('type'));

        $fileRules = ['required', 'file', 'max:10240'];
        $fileRules[] = $type?->acceptsOfficeDocument()
            ? 'mimes:pdf,doc,docx'
            : 'mimes:pdf,jpg,jpeg,png';

        return [
            'type' => ['required', Rule::enum(MembershipDocumentType::class)],
            'file' => $fileRules,
        ];
    }
}
