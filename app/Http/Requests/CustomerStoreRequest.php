<?php

namespace App\Http\Requests;

use App\Domain\Enums\TypeEnum;
use App\Domain\Rules\IsUniquePrimaryRegistry;
use App\Domain\Rules\IsValidCNPJ;
use App\Domain\Rules\IsValidCPF;
use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
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
            'primary_registry' => [
                'required',
                'string',
                'min:11',
                'max:14',
                'required',
                new IsValidCPF(),
                new IsValidCNPJ(),
                new IsUniquePrimaryRegistry()
            ],
            'primary_registry_type_id' => [
                'in:' . TypeEnum::PRIMARY_REGISTRY_PF . ',' . TypeEnum::PRIMARY_REGISTRY_PJ,
                'required'
            ],
            'name' => 'required|string|max:255|min:10',
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
            'primary_registry.min' => 'O CPF/CNPJ deve ter no mínimo 11 caracteres',
            'primary_registry.max' => 'O CPF/CNPJ deve ter no maximo 14 caracteres',
            'name.min' => 'Nome é deve ter no mínimo 10 caracteres',
            'name.max' => 'Nome é deve ter no maximo 255 caracteres',
            'name.string' => 'Nome deve ser um texto',
            'name.required' => 'Nome é obrigatório!',
            'primary_registry_type_id.in' => 'Tipo de registro deve ser CPF ou CNPJ',
            'primary_registry_type_id.required_if' => 'Tipo de registro é obrigatorio caso passe CPF/CNPJ',
        ];
    }
}
