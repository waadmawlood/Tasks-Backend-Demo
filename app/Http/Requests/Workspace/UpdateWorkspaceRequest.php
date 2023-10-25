<?php

namespace App\Http\Requests\Workspace;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkspaceRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
			'description' => 'nullable|string|max:65535',
			'image' => 'nullable|image|mimes:jpg,bmp,png',
			'is_active' => 'nullable|boolean',
            'is_custom_status' => 'nullable|boolean',
        ];
    }
}
