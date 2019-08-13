<?php
/**
 * Created by PhpStorm.
 * User: mohsen1
 * Date: 10/18/18
 * Time: 5:52 PM
 */

namespace Limito\Pay\Payment;


use Illuminate\Support\Facades\Auth;


class PaymentObject
{

    public
        $userId,
        $bankId,
        $amount,
        $name = 'unknown',
        $description = null,
        $bankResult = null,
        $payload = null,
        $status = 'unpaid',
        $paidAt = null;

    function userId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    function bankId($bankId)
    {
        $this->bankId = $bankId;
        return $this;

    }

    function amount($amount)
    {
        $this->amount = $amount;
        return $this;

    }

    function name($name)
    {
        $this->name = $name;
        return $this;
    }

    function description($description)
    {
        $this->description = $description;
        return $this;
    }

    function bankResult($bankResult)
    {
        $this->bankResult = $bankResult;
        return $this;
    }

    function payload($payload)
    {
        $this->payload = $payload;
        return $this;
    }

    function status($status)
    {
        $this->status = $status;
        return $this;
    }

    function paidAt($paidAt)
    {
        $this->paidAt = $paidAt;
        return $this;
    }

    function getUserId()
    {
        if (empty($this->userId))
            $this->userId(Auth::user()->id);

        return $this->userId;
    }

}