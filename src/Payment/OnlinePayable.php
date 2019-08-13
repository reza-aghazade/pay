<?php
/**
 * Created by PhpStorm.
 * User: mohsen1
 * Date: 10/19/18
 * Time: 12:35 PM
 */

namespace Limito\Pay\Payment;


use Limito\Pay\Payment\Bank\Bank;

trait OnlinePayable
{

    private $paymentCallbackUrl = 'payment/callback/';

    function onlinePayable($payload = [])
    {
        return (new Bank(
            $payload['bank_name'],
            $payload['payment_id'],
            $payload['amount']
        ))->setCallbackUrl($this->getPaymentCallbackUrl())
            ->startPayment();
    }
    function getPaymentCallbackUrl(){
        return $this->paymentCallbackUrl;
    }
}