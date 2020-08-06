<?php

namespace App\Domain\Rules;

use App\Domain\Entities\Customer;
use Illuminate\Contracts\Validation\Rule;

class HasBalance implements Rule
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
        $payer = request()->get('payer');

        if(blank($payer)) {
            return true;
        }

        $customer = Customer::find($payer);

        return $customer->balance >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Saldo insuficiente';
    }
}
