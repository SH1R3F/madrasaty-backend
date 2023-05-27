<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name'     => ['required', 'string', 'max:255'],
            'email'    => [
                'required',
                'email',
                'max:255',
                Rule::when(
                    request()->isMethod('POST'),
                    Rule::unique('users', 'email'),
                    Rule::unique('users', 'email')->ignore($this->user),
                )
            ],
            'role_id'  => ['required', 'numeric', 'exists:roles,id'],
            'password' => [
                Rule::when(request()->isMethod('POST'), 'required', 'nullable'),
                'string',
                'min:8',
                'max:255'
            ]
        ];
    }
}
