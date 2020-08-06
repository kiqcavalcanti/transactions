<?php

namespace App\Http\Controllers;

use App\Domain\Entities\Customer;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Http\Transformers\CustomerTransformer;
use App\Services\CustomerService;

class CustomerController extends BaseController
{
    public function __construct(CustomerService $service, CustomerTransformer $transformer)
    {
        $this->authorizeResource(Customer::class, 'customer');

        parent::__construct($service, $transformer);
    }

    /**
     * @param CustomerStoreRequest $request
     * @return mixed
     */
    public function store(CustomerStoreRequest $request)
    {
        return $this->response($this->getService()->create($request->all()));
    }

    /**
     * @param Customer $customer
     * @param CustomerUpdateRequest $request
     * @return mixed
     */
    public function update(Customer $customer, CustomerUpdateRequest $request)
    {
        return $this->response($this->getService()->update($customer, $request->all()));
    }

}
