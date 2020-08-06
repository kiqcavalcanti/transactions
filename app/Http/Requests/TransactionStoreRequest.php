<?php

namespace App\Http\Requests;

use App\Domain\Entities\Customer;
use App\Domain\Rules\HasBalance;
use App\Domain\Rules\IsPJTransactions;
use Illuminate\Foundation\Http\FormRequest;

class TransactionStoreRequest extends FormRequest
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
            'payer' => [
                'required',
                'exists:' . Customer::class . ',id',
            ],
            'payee' => [
                'required',
                'exists:' . Customer::class . ',id',
                new IsPJTransactions(),
            ],
            'value' => [
                'required',
                'numeric',
                'min:1',
                new HasBalance()
            ],
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
            'payer.exists' => 'Cliente pagador não encontrado',
            'payer.required' => 'Cliente pagador é obrigatório!',
            'payee.required' => 'Cliente recebedor é obrigatório!',
            'payee.exists' => 'Cliente recebedor não encontrado',
            'value.numeric' => 'O valor da transferencia deve ser numerico',
            'value.required' => 'O valor da transferencia é obrigatório!',
            'value.min' => 'O valor minimo da transferencia é 1',
        ];
    }
}
