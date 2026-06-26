<?php

namespace App\Http\Requests\Admin\Podcasts;

use Illuminate\Foundation\Http\FormRequest;

class StorePodcastRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'host_name'   => 'nullable|string|max:255',
            'summary'     => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'audio_file'  => 'nullable|file|mimes:mp3,wav,ogg,mpeg|max:50000',
            'audio_url'   => 'nullable|url',
            'duration'    => 'nullable|string|max:50',
            'embed_code'  => 'nullable|string',
            'castbox_url' => 'nullable|url',
            'spotify_url' => 'nullable|url',
            'status'      => 'required|in:draft,published',
        ];
    }
}
