<?php

namespace App\Http\Requests\Workspace;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkspaceRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:65535',
            'is_custom_status' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpg,png',
        ];

        if (!auth()->user() instanceof \App\Models\User) {
            $rules['user_id'] = 'required|string|max:255|exists:users,id';
        }

        return $rules;
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();
        $data['user_id'] ??= auth()->id(); // Set default user id if not set

        return $data;
    }
}
