<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isStudent() ?? false;
    }

    public function rules(): array
    {
        return [
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:20', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required' => 'Silakan berikan penilaian antara 1 hingga 5 bintang.',
            'rating.min' => 'Minimal rating adalah 1 bintang.',
            'rating.max' => 'Maksimal rating adalah 5 bintang.',
            'comment.required' => 'Jelaskan pengalaman Anda mengikuti kursus ini.',
            'comment.min' => 'Komentar minimal terdiri dari 20 karakter.',
            'comment.max' => 'Komentar maksimal 1000 karakter.',
        ];
    }
}
