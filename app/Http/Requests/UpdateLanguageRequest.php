<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLanguageRequest extends FormRequest
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
        $languageId = $this->route('language');
        return [
            'name' => ['required','string','max:100'],
            'code' => ['required','string','max:10','alpha_dash',Rule::unique('languages', 'code')->ignore($languageId)],
            'native_name' => ['nullable','string','max:100'],
            // 'status' => ['sometimes','in:active,inactive'],
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         'code.unique' => 'This language already exists.',
    //     ];
    // }
}
