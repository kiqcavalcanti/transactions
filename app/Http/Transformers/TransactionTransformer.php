<?php


namespace App\Http\Transformers;

use App\Domain\Entities\Transaction;
use App\Domain\Enums\TypeEnum;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
    public function transform(Transaction $transaction)
    {
        return [
            'id' => $transaction->id,
            'active' => $transaction->active,
            'created_at' => $transaction->created_at,
            'payer_customer_id' => $transaction->payer_customer_id,
            'payee_customer_id' => $transaction->payee_customer_id,
            'value' => $transaction->value,
            'status_type_id' => $transaction->status_type_id,
        ];
    }

    /**
     * @param Transaction $transaction
     * @return \League\Fractal\Resource\NullResource|\League\Fractal\Resource\Primitive
     */
    protected function includeStatusType(Transaction $transaction)
    {
        if (blank($transaction->status_type_id)) {
            return $this->null();
        }

        return $this->primitive([
            'data' => [
                'type' => 'Classification',
                'id' => $transaction->status_type_id,
                'attributes' => [
                    'description' => TypeEnum::DESCRIPTIONS[$transaction->status_type_id]
                ]
            ]
        ], null, 'Type');
    }
}
