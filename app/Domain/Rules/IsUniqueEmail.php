<?php

namespace App\Domain\Rules;

use App\Domain\Entities\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class IsUniqueEmail implements Rule
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

        $user = User::query()->where('email', $value)->first();

        if(blank($user)) {
            return true;
        }

        if(optional(Auth::user())->id === $user->id) {
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
        return 'Email já existe.';
    }
}
