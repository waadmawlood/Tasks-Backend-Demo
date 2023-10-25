<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class updateInforamtion extends FormRequest
{
    /**
     * Determine if the UserRequest is authorized to make this request.
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
            'name' => 'nullable|string|max:255',
            'password' => 'nullable|string|between:6,100|confirmed',
            'gender' => 'nullable|string|in:male,female',
            'timezone' => 'nullable|string|max:50',
        ];
    }
}
