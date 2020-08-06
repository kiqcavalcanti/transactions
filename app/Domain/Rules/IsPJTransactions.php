<?php

namespace App\Domain\Rules;

use App\Domain\Entities\Customer;
use App\Domain\Enums\TypeEnum;
use Illuminate\Contracts\Validation\Rule;

class IsPJTransactions implements Rule
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
        $customer = Customer::find($value);

        return $customer->primary_registry_type_id === TypeEnum::PRIMARY_REGISTRY_PF;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Esta operação nao é permitido para lojistas';
    }
}
