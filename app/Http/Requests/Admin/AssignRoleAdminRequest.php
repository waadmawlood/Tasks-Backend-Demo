<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AssignRoleAdminRequest extends FormRequest
{
    /**
     * Determine if the RoleRequest is authorized to make this request.
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
            'roles' => 'present|array',
            'roles.*' => 'nullable|integer|exists:roles,id,guard_name,admin',
        ];
    }
}
