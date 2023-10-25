<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the ProjectRequest is authorized to make this request.
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
            'name' => 'required|string|max:254',
			'description' => 'nullable|string|max:3000',
			'image' => 'nullable|image|mimes:jpg,bmp,png|max:3072',
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();
        $data['user_id'] ??= auth('user')->id();
        $data['workspace_id'] ??= getPermissionsTeamId();

        return $data;
    }
}
