<?php


namespace App\Http\Controllers;

use App\Http\Transformers\TransactionTransformer;
use App\Services\TransactionService;

class TransactionController extends BaseController
{
    public function __construct(TransactionService $service, TransactionTransformer $transformer)
    {
        parent::__construct($service, $transformer);
    }
}
