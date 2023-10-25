<?php

namespace App\Http\Requests\Status;

use Illuminate\Foundation\Http\FormRequest;

class StoreStatusRequest extends FormRequest
{
    /**
     * Determine if the StatusRequest is authorized to make this request.
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
			'name' => 'required|string|max:255',
			'color' => 'required|string|max:255',
			'position' => 'nullable|integer',
			'is_test' => 'nullable|boolean',
			'is_done' => 'nullable|boolean',
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();
        $data['user_id'] ??= auth()->id();
        $data['workspace_id'] ??= getPermissionsTeamId();

        return $data;
    }
}
