<?php

namespace App\Domain\Policies;

use App\Domain\Entities\Customer;
use App\Domain\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user, Customer $customer)
    {
        return $user->is_admin;
    }

    public function view(User $user, Customer $customer)
    {
        return $user->customer_id === $customer->id || $user->is_admin;
    }

    public function create(User $user, Customer $customer)
    {
        return blank($user->customer_id) || $user->is_admin;
    }

    public function update(User $user, Customer $customer)
    {
        return $user->customer_id === $customer->id || $user->is_admin;
    }

    public function delete(User $user, Customer $customer)
    {
        return $user->is_admin;
    }

    public function restore(User $user, Customer $customer)
    {
        return $user->is_admin;
    }

}
