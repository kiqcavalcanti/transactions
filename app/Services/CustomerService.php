<?php


namespace App\Services;

use App\Domain\Entities\Customer;

class CustomerService extends BaseService
{
    public function __construct(Customer $customer)
    {
        parent::__construct($customer);
    }
}
