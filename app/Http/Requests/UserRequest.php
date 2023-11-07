<?php

namespace App\Http\Requests;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('id');

        return [
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'min:3', 'max:255', 'email', "unique:users,email,{$userId}"]
        ];
    }


    public function messages()
    {
        return [
            'required' => 'Campo obrigatório.',
            'name.min' => 'Mínimo 3 caracteres.',
            'email.min' => 'Mínimo 3 caracteres.',
            'name.max' => 'Máximo 3 caracteres.',
            'email.max' => 'Máximo 3 caracteres.',
            'email.email' => 'Deve ser um Email válido.',
            'email.unique' => 'Email já cadastrado.'
        ];
    }
}
