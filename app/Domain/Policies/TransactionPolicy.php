<?php

namespace App\Domain\Policies;

use App\Domain\Entities\Transaction;
use App\Domain\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    public function create(User $user, Transaction $transaction)
    {
        return true;
    }

}
