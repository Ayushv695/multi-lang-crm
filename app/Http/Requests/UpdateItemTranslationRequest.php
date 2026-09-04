<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateItemTranslationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'language_id' => ['required','integer','exists:languages,id'],
            'name' => ['required','string','max:255'],
            'audio' => ['nullable','file','mimes:mp3,wav,ogg,m4a','max:20480'],
            // 'status' => ['sometimes','boolean'],
        ];
    }
}
