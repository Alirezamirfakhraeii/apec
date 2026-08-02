<?php

namespace App\Http\Requests\Admin\Media;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'files' => [
                'required',
                'array',
                'min:1',
            ],

            'files.*' => [
                'required',
                'file',
                'max:51200',

                'mimes:jpg,jpeg,png,webp,gif,pdf,' .
                'doc,docx,xls,xlsx,ppt,pptx,' .
                'zip,rar,txt,mp3,wav,mp4',
            ],

            'disk' => [
                'nullable',
                'string',
                'in:public',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'files' => 'فایل‌ها',
            'files.*' => 'فایل',
        ];
    }
}
