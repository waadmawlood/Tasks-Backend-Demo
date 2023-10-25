<?php

namespace App\Http\Requests\Status;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusRequest extends FormRequest
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
			'name' => 'nullable|string|max:255',
			'color' => 'nullable|string|max:255',
			'position' => 'nullable|integer',
			'is_test' => 'nullable|boolean',
			'is_done' => 'nullable|boolean',
        ];
    }
}
