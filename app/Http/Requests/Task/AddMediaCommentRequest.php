<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class AddMediaCommentRequest extends FormRequest
{
    /**
     * Determine if the TaskRequest is authorized to make this request.
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
			'attachments' => 'required|array|max:10',
			'attachments.*' => 'required|file|max:10240',
        ];
    }
}
