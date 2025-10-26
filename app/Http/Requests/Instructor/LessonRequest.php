<?php

namespace App\Http\Requests\Instructor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LessonRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'exists:lessons,lesson_id'],
            'youtube_link' => ['nullable', 'url'],
            'duration' => ['nullable', 'string', 'max:20'],
            'order_number' => ['nullable', 'integer', 'min:1'],
            'is_section' => ['nullable', 'boolean'],
            'is_free' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_section' => $this->boolean('is_section'),
            'is_free' => $this->boolean('is_free'),
        ]);
    }
}
