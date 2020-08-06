<?php


namespace App\Domain\Tasks\Transaction;


use App\Domain\Entities\Transaction;
use Illuminate\Support\Facades\Http;

class Validate
{
    public static function execute(Transaction $transaction)
    {
        try {
        $response = Http::retry(3, 500)->post(
            'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6',
            $transaction->toArray()
        );
        } catch (\Exception $e) {
            return false;
        }

        if ($response->failed()) {
            return false;
        }

        return strtolower($response['message']) === 'autorizado';

    }
}
