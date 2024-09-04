<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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
            'company' => ['required'],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'unique:contacts,email', 'email'],
            'user_id' => ['nullable']
        ];
    }

    public function validationData()
    {
        $this->merge(['user_id' => auth()->user()->id]);
        return $this->all();
    }
}
