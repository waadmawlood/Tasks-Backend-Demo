<?php

namespace App\Http\Requests\Permission;

use App\Helpers\Guard;
use App\Helpers\Utilities;
use Illuminate\Foundation\Http\FormRequest;

class ListPermissionsUserRequest extends FormRequest
{
    /**
     * Determine if the PermissionRequest is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Utilities::isUserOwnerWorkspace(Guard::authId(), getPermissionsTeamId()))
            return true;

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'permissions' => 'present|array',
            'permissions.*' => 'required|string|exists:permissions,name,guard_name,user',
        ];
    }
}
