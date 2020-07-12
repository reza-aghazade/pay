<?php
/**
 * Created by PhpStorm.
 * User: mohsen1
 * Date: 10/18/18
 * Time: 10:18 PM
 */

namespace Limito\Pay\Payment\Bank\Banks;


use Limito\Pay\Payment\Bank\BaseBank;
use Limito\Pay\Payment\Bank\iBank;

class Zarinpal extends BaseBank implements iBank
{
    protected $name = 'zarinpal';

    function startPayment()
    {
        $client = new \SoapClient($this->requestUrl(), ['encoding' => 'UTF-8']);


        $result = $client->PaymentRequest(

            [
                'MerchantID' => $this->merchantId(),
                'Amount' => $this->amount(),
                'CallbackURL' => $this->callbackUrl() . '/' . $this->paymentId(),
                'Description' => 'پرداخت آنلاین برای فاکتور شماره ' . $this->paymentId(),
            ]
        );

        //Redirect to URL You can do it also by creating a form
        if ($result->Status == 100) {
            return ['status' => true, 'data' => $this->payUrl() . '/' . $result->Authority];


            // Header('Location: https://www.zarinpal.com/pg/StartPay/'.$result->Authority);
//برای استفاده از زرین گیت باید ادرس به صورت زیر تغییر کند:
//Header('Location: https://www.zarinpal.com/pg/StartPay/'.$result->Authority.'/ZarinGate');
        } else {
            return ['status' => false, 'data' => json_encode($result)];

        }

    }

    function callback()
    {
        $client = new \SoapClient($this->verificationUrl(), ['encoding' => 'UTF-8']);

        $result = $client->PaymentVerification(
            [
                'MerchantID' => $this->merchantId(),
                'Authority' => $this->authority(),
                'Amount' => $this->amount(),
            ]
        );

        if ($result->Status == 100) {

            return ['status' => true, 'data' => ['ref_id' => $result->RefID]];
        } else {
            return ['status' => false, 'message' => 'مشکلی رخ داده است', 'data' => ['status' => $result->Status]];
        }
    }
}
