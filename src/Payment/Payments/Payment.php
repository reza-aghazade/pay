<?php
/**
 * Created by PhpStorm.
 * User: mohsen1
 * Date: 10/18/18
 * Time: 7:06 PM
 */

namespace Limito\Pay\Payment\Payments;


use Limito\Pay\Payment\OnlinePayable;
use Limito\Pay\Payment\PaymentNotifier;
use Limito\Pay\Payment\PaymentSystem;
use Limito\Pay\Transaction\Transaction;
use App\User;


class Payment extends PaymentSystem
{

    use PaymentNotifier,OnlinePayable;

    function handle()
    {
        // TODO: Implement handle() method.
    }


    function onPaid(\App\Payment $payment)
    {
        $user = User::find($payment->user_id);
        return Transaction::type(1)
            ->amount($payment->amount)
            ->user($user)
            ->description('online payment')
            ->payload(json_encode([
                'payment_id' => $payment->id
            ]))
            ->create();
    }

}