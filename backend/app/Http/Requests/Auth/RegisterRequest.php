<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required'],
            'email' => ['required', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'same:password'],
        ];
    }

    /**
     * Custom messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'confirm_password.same' => 'Password does not match.',
        ];
    }

    /**
     * Prep data for validation
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        $this->merge([
            'active_voter' => $this->active_voter == 'Yes' ? 1 : 0,
        ]);
    }
}
