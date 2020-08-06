<?php

namespace App\Http\Requests;

use App\Rules\isValidEmail;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['min:10', 'max:255', 'email', new isValidEmail()],
            'name' => 'string|max:255|min:10',
            'password' => 'string|min:6'
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.email' => 'Email invalido',
            'email.min' => 'Email deve ter no mínimo 10 caracteres',
            'email.max' => 'Email deve ter no maximo 255 caracteres',
            'name.min' => 'Nome é deve ter no mínimo 10 caracteres',
            'name.max' => 'Nome é deve ter no maximo 255 caracteres',
            'name.string' => 'Nome deve ser um texto',
            'password.string' => 'Senha deve ser um texto',
            'password.min' => 'Senha deve ter no mínimo 6 caracteres',
        ];
    }
}
