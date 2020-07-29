<?php


namespace Limito\Pay\Payment\Bank\Banks;


use App\User;
use GuzzleHttp\Client;
use Limito\Pay\Payment\Bank\BaseBank;
use Limito\Pay\Payment\Bank\iBank;

class Payping extends BaseBank implements iBank
{
    private $headers = [];
    private $restCall;

    private function setHeader()
    {
        $this->headers = [
            'Content-type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->merchantId(),
        ];

        $this->setClient();
    }

    private function setClient()
    {
        $this->restCall = new Client([
            'base_uri' => $this->requestUrl(),
            'headers' => $this->headers
        ]);
    }

    private function getUser($userId)
    {
        return User::find($userId);
    }

    function startPayment()
    {
        $this->setHeader();
        $user = $this->getUser($this->payment()->user_id);

        $args = [
            "amount" => $this->amount(),
            "payerIdentity" => $user->id,
            "payerName" => $user->name,
            "description" => "پرداخت آنلاین",
            "returnUrl" => $this->callbackUrl(),
            "clientRefId" => $this->paymentId()
        ];


        try {
            $result = $this->restCall->post($this->requestUrl(), ["body" => json_encode($args)]);
            $result = json_decode($result->getBody()->getContents(), false);

            if (empty($result->code)) {
                return ['status' => false, 'data' => json_encode($result)];
            }

            return ['status' => true, 'data' => $this->payUrl() . 'pay/gotoipg/' . $result->code];

        } catch (\Exception $ex) {
            $err_msg = $ex->getMessage();
            return ['status' => false, 'data' => json_encode($err_msg)];
        }
    }

    function callback()
    {
        $this->setHeader();

        $args = [
            "refId" => $this->authority(),
            "amount" => $this->amount()
        ];

        try {
            $result = $this->restCall->post($this->verificationUrl() . 'pay/verify', ['body' => json_encode($args)]);
        }catch (\Exception $ex){
            $err_msg = $ex->getMessage();
            return ['status' => false, 'data' => json_encode($err_msg)];
        }

        if ($result->getStatusCode() >= 200 && $result->getStatusCode() < 300) {
            return success(['ref_id' => $this->authority()]);
        }
        return error('مشکلی رخ داده است');
    }
}