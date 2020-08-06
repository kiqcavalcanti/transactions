<?php


namespace App\Domain\Enums;


class TypeEnum
{
    const PRIMARY_REGISTRY_PF = '1be68918-365b-4230-aa93-f58c855f8b10';
    const PRIMARY_REGISTRY_PJ = 'b3c38aa4-56ac-4c9b-b91c-58608292a785';

    const TRANSACTION_STATUS_OPEN = '05d91548-d605-4d29-99bd-4063c140b0ba';
    const TRANSACTION_STATUS_AUTHORIZED = '05d91548-d605-4d29-99bd-4063c140b0ba';
    const TRANSACTION_STATUS_DENIED = '1d452acc-9980-4223-be69-0faa6c3222c0';


    public const DESCRIPTIONS = [
        self::PRIMARY_REGISTRY_PF => 'Registro PF',
        self::PRIMARY_REGISTRY_PJ => 'Registro PJ',
        self::TRANSACTION_STATUS_OPEN => 'Transação em aberto',
        self::TRANSACTION_STATUS_AUTHORIZED => 'Transação autorizada',
        self::TRANSACTION_STATUS_DENIED => 'Transação negada',
    ];

}
