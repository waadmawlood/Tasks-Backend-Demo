<?php

namespace App\Http\Requests\Workspace;

use Illuminate\Foundation\Http\FormRequest;

class AssignUsersWorkspaceRequest extends FormRequest
{
    /**
     * Determine if the Workspace Request is authorized to make this request.
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
            'users' => 'present|array',
			'users.*' => 'required|uuid|exists:users,id',
        ];
    }
}
