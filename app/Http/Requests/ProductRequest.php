<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'sometimes',
            'size' => 'nullable',
            'stock' => "required|numeric",
            'cat_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric'
        ];
    }
}
