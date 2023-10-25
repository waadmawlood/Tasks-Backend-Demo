<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskPriority;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\In;

class StoreTaskRequest extends FormRequest
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
            'title' => 'required|string|max:255',
			'description' => 'nullable|string|max:65535',
			'task_id' => 'nullable|string|max:255|exists:tasks,id',
			'priority' => ['nullable', new In(TaskPriority::names())],
			'expiration' => 'nullable|date',
        ];
    }

    public function validated($key = null, $default = null)
    {
        // setPermissionsTeamId()
        $data = parent::validated();
        $data['user_id'] ??= auth()->id();
        $data['project_id'] ??= getProjectId();
        $data['status_id'] ??= getFirstStatusId();

        return $data;
    }
}
