<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($this->route('product'))
            ],
            'price_regular' => 'required|numeric|min:0',
            'price_sale' => 'nullable|numeric|min:0|lte:price_regular',
            'category_id' => 'required|exists:categories,id',
            'image_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'material' => 'nullable|string',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'status' => 'nullable|boolean',
            'is_trending' => 'nullable|boolean',
            'is_sale' => 'nullable|boolean',
            'is_new' => 'nullable|boolean',
            'is_show_home' => 'nullable|boolean',
        ];
    }
}
