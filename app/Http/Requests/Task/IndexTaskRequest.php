<?php

namespace App\Http\Requests\Task;

use App\Http\Requests\Pagination;

class IndexTaskRequest extends Pagination
{
    /**
     * Determine if the user is authorized to make this request.
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
            ...parent::rules(),
            'is_test' => 'nullable|boolean',
            'is_done' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'is_archived' => 'nullable|boolean',
        ];
    }
}
