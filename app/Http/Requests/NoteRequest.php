<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'note'         => ['required', 'string'],
            'points'       => ['required', 'numeric'],
            'student_id'   => [Rule::when(!$this->classroom_id, ['required_without:classroom_id', 'exists:students,id'])],
            'classroom_id' => [Rule::when(!$this->student_id, ['required_without:student_id', 'exists:classrooms,id'])]
        ];
    }
}
