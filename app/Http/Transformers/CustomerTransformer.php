<?php


namespace App\Http\Transformers;

use App\Domain\Entities\Customer;
use App\Domain\Enums\TypeEnum;
use League\Fractal\TransformerAbstract;

class CustomerTransformer extends TransformerAbstract
{
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
     * @return \League\Fractal\Resource\NullResource|\League\Fractal\Resource\Primitive
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
