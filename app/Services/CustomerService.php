<?php

namespace App\Services;

use App\Domain\Entities\Customer;
use App\Domain\Tasks\User\UpdateUserFromNewCustomer;

class CustomerService extends BaseService
{
    public function __construct(Customer $customer)
    {
        parent::__construct($customer);
    }

    public function create(array $attributes)
    {
        $customer = parent::create($attributes);

        UpdateUserFromNewCustomer::execute($customer, data_get($attributes, 'user_id'));

        return $customer;
    }
}
