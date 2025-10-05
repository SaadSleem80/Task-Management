<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskCreateRequest extends FormRequest
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
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['sometimes', 'nullable', 'string'],
            'user_id'       => ['required', Rule::exists('users', 'id')],
            'parent_id'     => ['sometimes', 'nullable', Rule::exists('tasks', 'id')->where('status', 'pending')],
            'due_date'      => ['required', 'date'],
        ];
    }
}
