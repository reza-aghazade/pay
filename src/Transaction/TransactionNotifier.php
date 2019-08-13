<?php
/**
 * Created by PhpStorm.
 * User: mohsen1
 * Date: 10/19/18
 * Time: 11:57 AM
 */

namespace Limito\Pay\Transaction;



use Limito\Notifier\Traits\Notifiable;

trait TransactionNotifier
{
    use Notifiable;

    function sendTransactionNotification($payload = [])
    {
        $this->toMobile = $payload['mobile'];
        $this->smsBody = $payload['body'];
        $this->sendNotification();
    }
}