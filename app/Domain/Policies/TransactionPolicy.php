<?php

namespace App\Domain\Policies;

use App\Domain\Entities\Transaction;
use App\Domain\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->customer_id === request()->get('payer');
    }

    public function view(User $user, Transaction $transaction)
    {
        return $user->customer_id === $transaction->payer_customer_id || $user->is_admin;
    }

    public function viewAny(User $user)
    {
        return true;
    }

}
