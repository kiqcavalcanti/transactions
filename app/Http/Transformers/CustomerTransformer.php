<?php


namespace App\Http\Transformers;

use App\Domain\Entities\Customer;
use League\Fractal\TransformerAbstract;

class CustomerTransformer extends TransformerAbstract
{
    public function transform(Customer $customer)
    {
        return [];
    }
}
