<?php

namespace App\Domain\Actions\Transaction;

use App\Domain\Entities\Transaction;
use App\Domain\Enums\TypeEnum;
use App\Domain\Tasks\BaseCreate;
use App\Domain\Tasks\Customer\UpdateBalanceFromTransaction;
use App\Domain\Tasks\Notification\SendTransactionNotification;
use App\Domain\Tasks\Transaction\Validate;

class CreateAction
{
    /**
     * @param array $attributes
     * @return Transaction
     */
    public static function execute(array $attributes): Transaction
    {
        $transaction = new Transaction();

        $transaction->payer_customer_id = $attributes['payer'];
        $transaction->payee_customer_id = $attributes['payee'];
        $transaction->value = $attributes['value'];
        $transaction->status_type_id = TypeEnum::TRANSACTION_STATUS_OPEN;

        $isValid = Validate::execute($transaction);

        if ($isValid) {
            $transaction->status_type_id = TypeEnum::TRANSACTION_STATUS_AUTHORIZED;
        } else {
            $transaction->status_type_id = TypeEnum::TRANSACTION_STATUS_DENIED;
        }

        UpdateBalanceFromTransaction::execute($transaction);

        /**
         * @var Transaction $transaction
         */
        $transaction = BaseCreate::execute($transaction);

        SendTransactionNotification::execute($transaction);

        return $transaction;
    }
}
