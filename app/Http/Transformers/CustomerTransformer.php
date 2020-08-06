<?php


namespace App\Http\Transformers;

use App\Domain\Entities\Customer;
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
}
