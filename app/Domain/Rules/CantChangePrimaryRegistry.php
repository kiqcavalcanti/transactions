<?php

namespace App\Domain\Rules;

use App\Domain\Entities\Customer;
use Illuminate\Contracts\Validation\Rule;

class CantChangePrimaryRegistry implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(blank($value)) {
            return true;
        }

        $customer = Customer::where('primary_registry', $value)->first();

        $customerToUpdate = request()->route('customer');

        if(optional($customer)->id === $customerToUpdate->id) {
            return true;
        }

        return false;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Não é permitido alteração de CPF/CNPJ';
    }
}
