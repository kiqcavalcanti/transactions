<?php


namespace App\Http\Controllers;

use App\Domain\Entities\Transaction;
use App\Http\Requests\TransactionStoreRequest;
use App\Http\Transformers\TransactionTransformer;
use App\Services\TransactionService;

class TransactionController extends BaseController
{
    public function __construct(TransactionService $service, TransactionTransformer $transformer)
    {
        parent::__construct($service, $transformer);
    }

    public function show(Transaction $transaction)
    {
        return parent::baseShow($transaction);
    }

    /**
     * @param TransactionStoreRequest $request
     * @return mixed
     */
    public function store(TransactionStoreRequest $request)
    {
        return $this->response($this->getService()->create($request->all()));
    }

}
