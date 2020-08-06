<?php


namespace App\Http\Transformers;

use App\Domain\Entities\Transaction;
use App\Domain\Enums\TypeEnum;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\NullResource;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Primitive;

class TransactionTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'statusType',
        'payer',
        'payee',
    ];

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
     * @return Collection|Item|NullResource
     */
    public function includePayer(Transaction $transaction)
    {
        if(blank($transaction->payer_customer_id)) {
            return $this->null();
        }

        return $this->item($transaction->payer, new  CustomerTransformer, 'Customer');
    }

    /**
     * @param Transaction $transaction
     * @return Collection|Item|NullResource
     */
    public function includePayee(Transaction $transaction)
    {
        if(blank($transaction->payee_customer_id)) {
            return $this->null();
        }

        return $this->item($transaction->payee, new  CustomerTransformer, 'Customer');
    }

    /**
     * @param Transaction $transaction
     * @return NullResource|Primitive
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
