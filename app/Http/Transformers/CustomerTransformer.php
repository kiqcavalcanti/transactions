<?php

namespace App\Http\Transformers;

use App\Domain\Entities\Customer;
use App\Domain\Enums\TypeEnum;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\NullResource;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Primitive;

class CustomerTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'user',
        'primaryRegistryType',
    ];

    public function transform(Customer $customer)
    {
        return [
            'id' => $customer->id,
            'name' => $customer->name,
            'primary_registry' => $customer->primary_registry,
            'primary_registry_type_id' => $customer->primary_registry_type_id,
        ];
    }

    /**
     * @param Customer $customer
     * @return Item|NullResource
     */
    public function includeUser(Customer $customer)
    {
        if(blank($customer->user)) {
            return $this->null();
        }

        return $this->item($customer->user, new  UserTransformer, 'User');
    }

    /**
     * @param Customer $customer
     * @return NullResource|Primitive
     */
    protected function includePrimaryRegistryType(Customer $customer)
    {
        if (blank($customer->primary_registry_type_id)) {
            return $this->null();
        }

        return $this->primitive([
            'data' => [
                'type' => 'Classification',
                'id' => $customer->primary_registry_type_id,
                'attributes' => [
                    'description' => TypeEnum::DESCRIPTIONS[$customer->primary_registry_type_id]
                ]
            ]
        ], null, 'Type');
    }
}
