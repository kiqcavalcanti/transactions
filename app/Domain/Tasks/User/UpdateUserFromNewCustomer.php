<?php

namespace App\Domain\Tasks\User;

use App\Domain\Entities\BaseModel;
use App\Domain\Entities\Customer;
use App\Domain\Entities\User;
use App\Domain\Tasks\BaseUpdate;
use Illuminate\Support\Facades\Auth;

class UpdateUserFromNewCustomer
{
    /**
     * @param Customer $customer
     * @param string|null $userId
     * @return User|null|BaseModel
     */
    public static function execute(Customer $customer, ?string $userId = null): ?User
    {
        if(Auth::user()->is_admin) {
            $user = !blank($userId) ? User::find($userId) : null;
        } else {
            $user = Auth::user();
        }

        if(blank($user)) {
            return null;
        }

        $user->customer_id = $customer->id;

        return BaseUpdate::execute($user);
    }
}
