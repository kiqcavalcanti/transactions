<?php


namespace App\Http\Transformers;

use App\Domain\Entities\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
    public function transform(Transaction $transaction)
    {
        return [];
    }
}
