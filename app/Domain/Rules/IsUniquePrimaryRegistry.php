<?php

namespace App\Domain\Rules;

use App\Domain\Entities\Customer;
use App\Domain\Enums\TypeEnum;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class IsUniquePrimaryRegistry implements Rule
{
    public string $message = '';
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

        $customer = Customer::query()->where('primary_registry', $value)->first();

        if(blank($customer)) {
            return true;
        }

        if(optional(Auth::user())->customer_id === $customer->id) {
            return true;
        }

        $registryType = $customer->primary_registry_type_id === TypeEnum::PRIMARY_REGISTRY_PF ? 'CPF' : 'CNPJ';

        $this->message = $registryType. ' já existe.';

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return  $this->message;

    }
}
