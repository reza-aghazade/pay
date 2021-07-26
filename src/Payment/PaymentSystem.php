<?php
/**
 * Created by PhpStorm.
 * User: mohsen1
 * Date: 10/18/18
 * Time: 6:33 PM
 */

namespace Limito\Pay\Payment;

use Limito\Pay\Bank;
use Limito\Pay\Payment as Model;
use Limito\Pay\Payment;
use App\User;

const STATUS_PAYMENT_PAID = 'paid';
const STATUS_PAYMENT_UNPAID = 'unpaid';
abstract class PaymentSystem
{

    public $payment;
    public $paymentId;

    function __construct(PaymentObject $payment = null)
    {
        $this->payment = $payment;
    }


    abstract function handle();


    function create()
    {

        $model = new Model();
        $model->user_id = $this->payment->getUserId();
        $model->bank_id = $this->payment->bankId;
        $model->name = $this->payment->name;
        $model->description = $this->payment->description;
        $model->amount = $this->payment->amount;
        $model->bank_result = $this->payment->bankResult;
        $model->payload = $this->payment->payload;
        $model->status = $this->payment->status;
        $model->paid_at = $this->payment->paidAt;
        $model->save();
        $this->paymentId = $model->id;

        if (method_exists($this, 'sendPaymentNotification')) {
            $user = User::find($this->payment->getUserId());
            $payload = [
                'payment_id' => $model->id,
                'mobile' => $user->mobile,
                'amount' => $model->amount,
            ];

            $this->sendPaymentNotification($payload);
        }

        if (method_exists($this, 'onlinePayable')) {

            $bank = Bank::find($this->payment->bankId);
            $payload = [
                'bank_name' => $bank->name,
                'payment_id' => $model->id,
                'amount' => $model->amount,
            ];

            return $this->onlinePayable($payload);
        }

        return $model;
    }


    abstract function onPaid(Payment $payment);
}