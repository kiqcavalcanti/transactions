<?php

namespace App\Domain\Rules;

use App\Domain\Entities\Customer;
use App\Domain\Enums\TypeEnum;
use Illuminate\Contracts\Validation\Rule;

class IsValidCPF implements Rule
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

        if(blank(request()->get('primary_registry_type_id'))) {
            return true;
        }

        if(request()->get('primary_registry_type_id') === TypeEnum::PRIMARY_REGISTRY_PJ) {
            return true;
        }

        return isValidCPF($value);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'CPF inválido';
    }
}
