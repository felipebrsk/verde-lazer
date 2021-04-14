<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsUpdateRequest extends FormRequest
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
            'short_des' => 'required|string',
            'description' => 'required|string',
            'photo' => 'sometimes',
            'logo' => 'sometimes',
            'address' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ];
    }
}
