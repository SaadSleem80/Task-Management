<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskUpdateRequest extends FormRequest
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
        $user = $this->user();
    
        // Fallback for Scribe or unauthenticated contexts
        if (!$user) {
            return [
                'title'       => ['sometimes', 'nullable', 'string', 'max:255'],
                'description' => ['sometimes', 'nullable', 'string'],
                'user_id'     => ['sometimes', 'nullable', Rule::exists('users', 'id')],
                'parent_id'   => ['sometimes', 'nullable', Rule::exists('tasks', 'id')->where('status', 'pending')],
                'status'      => ['sometimes', 'nullable', Rule::in(['pending', 'in_progress', 'completed'])],
            ];
        }
    
        if ($user->hasRole('user')) {
            return [
                'status' => ['required', Rule::in(['pending', 'completed', 'cancelled'])],
            ];
        }
    
        return [
            'title'       => ['sometimes', 'nullable', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'user_id'     => ['sometimes', 'nullable', Rule::exists('users', 'id')],
            'parent_id'   => ['sometimes', 'nullable', Rule::exists('tasks', 'id')->where('status', 'pending')],
            'status'      => ['sometimes', 'nullable', Rule::in(['pending', 'in_progress', 'completed'])],
        ];
    }
}
