<?php
/**
 * Created by PhpStorm.
 * User: mohsen1
 * Date: 10/18/18
 * Time: 6:49 PM
 */

namespace Limito\Pay\Payment;



use Limito\Notifier\Traits\Notifiable;

trait PaymentNotifier
{
    use Notifiable;

    function sendPaymentNotification($payload = [])
    {

        $this->smsBody = $this->getSmsBody($payload);



        if (!empty($payload['mobile']))
            $this->toMobile = $payload['mobile'];

        $this->sendNotification();

    }

    function getSmsBody($payload=null){
       return __('financial/payment.created', ['payment_id'=> $payload['payment_id'], 'amount' => $payload['amount']]);
    }
}