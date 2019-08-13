<?php
/**
 * Created by PhpStorm.
 * User: mohsen1
 * Date: 10/18/18
 * Time: 10:47 PM
 */

namespace Limito\Pay\Payment\Bank;



use Limito\Pay\Payment\Payments\Payment;
use Limito\Pay\Payment\PaymentSystem;
use Illuminate\Support\Facades\Log;

class Bank extends BaseBank implements iBank
{

    /**
     * @var iBank
     */
    protected $gateway;

    function __construct($bankName = null, $paymentId, $amount)
    {
        $this->name = $bankName;
        $this->paymentId = $paymentId;
        $this->amount = $amount;

        $gateway = $this->gatewayClass();
        $this->gateway = new $gateway();
    }

    function startPayment()
    {
        if ($this->amount() < $this->minAmount()) {
            return Response::Instance()->error(__('financial/bank.min_amount'));
        }

        Log::info('payment====>start ====>payment id= ' . $this->paymentId());
        $this->gateway->paymentId = $this->paymentId;
        $this->gateway->amount = $this->amount;
        $this->gateway->setCallbackUrl($this->callbackUrl);
        $result = $this->gateway->startPayment();
        $payment = $this->payment();
        if ($result['status']) {
            $payment->bank_result = 'send to bank';
            Log::info('payment====>send to bank ====>payment id= ' . $this->paymentId() . ' ====> result = ' . $payment->bank_result);
            $payment->save();
            return Response::Instance()->data(['url' => $result['data']])->success();
        } else {
            Log::error('payment====>bank result ====>payment id= ' . $this->paymentId() . ' ====> result = ' . $result['data']);
            $payment->bank_result = $result['data'];
            $payment->save();
            return Response::Instance()->error(__('financial/bank.unknown_error'));
        }
    }

    function callback(PaymentSystem $paymentSystem = null)
    {
        $this->gateway->amount = $this->amount();
        $this->gateway->paymentId = $this->paymentId();
        $this->gateway->authority = $this->authority();
        $result = $this->gateway->callback();
        $payment = $this->payment();
        if ($result['status']) {
            if ($payment->status === 'paid') {
                return Response::Instance()->error(__('financial/bank.payment_duplicate'));
            }
            $payment->status = 'paid';
            $payment->bank_result = json_encode($result['data']);
            $payment->save();
            if (empty($paymentSystem))
                (new Payment())->onPaid($payment);
            else
                $paymentSystem->onPaid($payment);
        } else {
            $payment->status = 'unpaid';
            $payment->bank_result = json_encode($result['data']);
            $payment->save();
        }

        return $result;
    }
}