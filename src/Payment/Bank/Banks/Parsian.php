<?php


namespace Limito\Pay\Payment\Bank\Banks;


use Limito\Pay\Payment\Bank\BaseBank;
use Limito\Pay\Payment\Bank\iBank;

class Parsian extends BaseBank implements iBank
{
    protected $name = 'parsian';

    function startPayment()
    {

        $params = [
            'LoginAccount' => $this->merchantId(),
            'Amount' => $this->amount(),
            "OrderId" => $this->paymentId(),
            'CallBackUrl' => $this->callbackUrl() . '/' . $this->paymentId(),
//                    'Description' => 'پرداخت آنلاین برای فاکتور شماره ' . $this->paymentId(),
        ];
        $context = stream_context_create(
            [
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false
                )
            ]
        );
        $client = new \SoapClient($this->requestUrl(), [
            'stream_context' => $context
        ]);

        try {
            $result = $client->SalePaymentRequest([
                "requestData" => $params
            ]);
            if ($result->SalePaymentRequestResult->Token && $result->SalePaymentRequestResult->Status === 0) {
                return ['status' => true, 'data' => $this->payUrl() . '/?Token=' . $result->SalePaymentRequestResult->Token];

            } elseif ($result->SalePaymentRequestResult->Status != '0') {
                return ['status' => false, 'data' => json_encode($result)];
            }
        } catch (Exception $ex) {
            $err_msg = $ex->getMessage();
            return ['status' => false, 'data' => json_encode($err_msg)];
        }
    }

    function callback()
    {

        $params = array(
            "LoginAccount" => $this->merchantId(),
            "Token" => $this->authority()
        );
        $context = stream_context_create(
            [
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false
                )
            ]
        );
        $client = new \SoapClient($this->verificationUrl(), [
            'stream_context' => $context
        ]);

        try {
            $result = $client->ConfirmPayment(array(
                "requestData" => $params
            ));
            if ($result->ConfirmPaymentResult->Status != '0') {
                return error('مشکلی رخ داده است', ['status' => $result->ConfirmPaymentResult->Status]);
            } else {
                return success(['ref_id' => $result->ConfirmPaymentResult->RRN]);
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }

    }
}