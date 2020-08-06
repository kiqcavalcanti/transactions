<?php

namespace App\Http\Transformers;

use App\Domain\Entities\User;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\NullResource;
use League\Fractal\Resource\Item;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'customer',
    ];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'active' => true,
            'created_at' => $user->created_at,
            'customer_id' => $user->customer_id,
            'email' => $user->email,
        ];
    }

    /**
     * @param User $user
     * @return Item|NullResource
     */
    public function includeCustomer(User $user)
    {
        if(blank($user->customer)) {
            return $this->null();
        }

        return $this->item($user->customer, new  CustomerTransformer(), 'Customer');
    }

}
