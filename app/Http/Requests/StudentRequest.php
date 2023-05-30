<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'email' => [
                'required',
                'email',
                Rule::when(
                    request()->isMethod('POST'),
                    Rule::unique('students'),
                    Rule::unique('students')->ignore($this->student),
                )
            ],
            'password' => ['required', 'string', 'min:8', 'max:255']
        ];
    }
}
