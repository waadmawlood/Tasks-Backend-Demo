<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
			'email' => 'nullable|email|max:255|unique:users,email',
			'password' => 'nullable|min:6|max:255',
			'gender' => 'nullable|string|in:male,female',
			'timezone' => 'nullable|string|max:255',
			'is_ban' => 'nullable|boolean',
        ];
    }
}
