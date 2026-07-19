<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CategoryRequest extends FormRequest
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
            'parent_id' => 'nullable|max:255',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
            'top' => 'nullable',
            'column' => 'nullable',
            'sort_order' => 'nullable',
            'slug' => 'nullable',
            'status' => 'nullable|boolean',
            'store_ids' => 'nullable|array',
            'store_ids.*' => 'integer|exists:stores,id',
            'translations.*.name' => 'required|string|max:255',
            'translations.*.title_tag' => 'nullable|string|max:255',
            'translations.*.alt_tag' => 'nullable|string|max:255',
            'translations.*.description' => 'nullable|string',
            'translations.*.meta_description' => 'nullable|string',
            'translations.*.meta_keywords' => 'nullable|string|max:255',
        ];
    }

    public function attributes(): array
    {
        return [
            'translations.*.name' => 'Name',
            'translations.*.title_tag' => 'Title Tag',
            'translations.*.alt_tag' => 'Alt Tag',
            'translations.*.description' => 'Description',
            'translations.*.meta_description' => 'Meta Description',
            'translations.*.meta_keywords' => 'Meta Keywords',
        ];
    }
}
