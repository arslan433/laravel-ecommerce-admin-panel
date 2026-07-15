<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LanguageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
      return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:32',
            'directory' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'default' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ];
    }
}
