<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskPriority;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\In;

class UpdateTaskRequest extends FormRequest
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
            'title' => 'nullable|string|max:255',
			'description' => 'nullable|string|max:65535',
			'status_id' => 'nullable|string|max:255|exists:statuses,id',
			'priority' => ['nullable', new In(TaskPriority::names())],
			'expiration' => 'nullable|date_format:Y-m-d H:i:s',
        ];
    }
}
