<?php


namespace Limito\Pay\Payment\Bank\Banks;


use Limito\Pay\Payment\Bank\BaseBank;
use Limito\Pay\Payment\Bank\iBank;

class Mellat extends BaseBank implements iBank
{
    protected $name = 'mellat';

    private $username;
    private $password;

    private function setUserName()
    {
        $this->username = $this->config->get("bank.gateways.mellat.username");
        return $this;
    }

    private function setPassWord()
    {
        $this->username = $this->config->get("bank.gateways.mellat.password");
        return $this;
    }

    function startPayment()
    {
        $this->setUserName();
        $this->setPassWord();

        $dateTime = new \DateTime();

        $amount = $this->amount() * 10;
        //-- تبدیل اطلاعات به آرایه برای ارسال به بانک
        $parameters = [
            'terminalId' => $this->merchantId(),
            'userName' => $this->username,
            'userPassword' => $this->password,
            'orderId' => $this->paymentId(),
            'amount' => $amount,
            'localDate' => $dateTime->format('Ymd'),
            'localTime' => $dateTime->format('His'),
            'additionalData' => "",
            'callBackUrl' => $this->callbackUrl() . '/' . $this->paymentId(),
            'payerId' => 0
        ];
        try {
            $soap = new SoapClient($this->requestUrl());
            $response = $soap->bpPayRequest($parameters);
        } catch (\Exception $e) {
            $err_msg = $e->getMessage();
            return ['status' => false, 'data' => json_encode($err_msg)];
        }

        $response = explode(',', $response->return);
        if ($response[0] == "0") {
            return ['status' => true, 'data' => $this->payUrl() . '?RefId=' . $response[1]];

        } elseif ($response[0] != '0') {
            return ['status' => false, 'data' => json_encode($response)];
        }
    }

    function callback()
    {
        $this->setUserName();
        $this->setPassWord();
        $parameters = [
            'terminalId' => $this->merchantId(),
            'userName' => $this->username,
            'userPassword' => $this->password,
            'orderId' => $this->paymentId(),
            'saleOrderId' => $this->paymentId(),
            'saleReferenceId' => $this->authority()
        ];

        try {
            $soap = new SoapClient($this->requestUrl());
            $response = $soap->bpVerifyRequest($parameters);
        } catch (\Exception $e) {
            $err_msg = $e->getMessage();
            return ['status' => false, 'data' => json_encode($err_msg)];
        }

        if ($response->return !== '0') {
            return error('مشکلی رخ داده است');
        } else {
            return success(['ref_id' => $this->authority()]);
        }
    }
}