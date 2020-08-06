<?php


namespace App\Domain\Tasks\Customer;


use App\Domain\Entities\Customer;
use App\Domain\Entities\Transaction;
use App\Domain\Enums\TypeEnum;

class UpdateBalanceFromTransaction
{
    /**
     * @param Transaction $transaction
     * @return bool
     */
    public static function execute(Transaction $transaction)
    {
        if ($transaction->status_type_id !== TypeEnum::TRANSACTION_STATUS_AUTHORIZED) {
            return false;
        }

        $payer = Customer::find($transaction->payer_customer_id);
        $payer->balance -= $transaction->value;

        $payee = Customer::find($transaction->payee_customer_id);
        $payee->balance += $transaction->value;

        $payer->save();
        $payee->save();

        return true;
    }
}
