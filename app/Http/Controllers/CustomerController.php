<?php


namespace App\Http\Controllers;


use App\Http\Transformers\CustomerTransformer;
use App\Services\CustomerService;

class CustomerController extends BaseController
{
    public function __construct(CustomerService $service, CustomerTransformer $transformer)
    {
        parent::__construct($service, $transformer);
    }
}
