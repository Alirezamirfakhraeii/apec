<?php

namespace App\Http\Requests\Admin\Podcasts;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePodcastRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id'  => 'nullable|exists:categories,id',
            'title'        => 'required|string|max:255',
            'summary'      => 'nullable|string',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'audio_url'    => 'nullable|mimes:mp3,wav,ogg|max:50000',
            'duration'     => 'nullable|string',
            'embed_code'   => 'nullable|string',
            'castbox_url'  => 'nullable|url',
            'spotify_url'  => 'nullable|url',
            'status'       => 'required|in:draft,published',
        ];
    }
}
