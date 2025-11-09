<?php

namespace App\Filament\Resources\Tasks\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_id' => 'required',
            'user_id' => 'required',
            'task_id' => 'required',
            'title' => 'required',
            'description' => 'required|string',
            'priority' => 'required',
            'status' => 'required',
            'due_date' => 'required|date',
            'created_by' => 'required',
            'modified_by' => 'required',
            'deleted_at' => 'required',
        ];
    }
}
