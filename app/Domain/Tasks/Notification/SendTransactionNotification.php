<?php


namespace App\Domain\Tasks\Notification;


use App\Domain\Entities\Transaction;
use App\Domain\Enums\TypeEnum;
use Illuminate\Support\Facades\Http;

class SendTransactionNotification
{
    public static function execute(Transaction $transaction)
    {
        if($transaction->status_type_id !== TypeEnum::TRANSACTION_STATUS_AUTHORIZED) {
            return false;
        }

        try {
            $response = Http::retry(3, 500)->post(
                'https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04',
                ['message' => 'Sua transferencia foi realizada com sucesso']
            );
        } catch (\Exception $e) {
            return false;
        }


        if ($response->failed()) {
            return false;
        }

        return strtolower($response['message']) === 'enviado';

    }
}
