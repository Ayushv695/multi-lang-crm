<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreLanguageRequest extends FormRequest
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
            'name' => ['required','string','max:100'],
            'code' => ['required','string','max:10','alpha_dash','unique:languages,code'],
            'native_name' => ['nullable','string','max:100'],
            // 'status' => ['nullable','in:active,inactive'],
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         'code.unique' => 'This language already exists.',
    //     ];
    // }
}
