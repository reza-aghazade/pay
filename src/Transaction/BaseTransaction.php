<?php
/**
 * Created by PhpStorm.
 * User: mohsen1
 * Date: 10/19/18
 * Time: 11:47 AM
 */

namespace Limito\Pay\Transaction;




abstract class BaseTransaction
{
    public $type, $user, $description, $amount, $payload;


    function user( $user)
    {
        $this->user = $user;
        return $this;
    }


    function amount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    function description($description)
    {
        $this->description = $description;
        return $this;
    }

    function payload($payload)
    {
        $this->payload = $payload;
        return $this;
    }

    function create()
    {
        $model = new \Limito\Pay\Transaction();
        $model->user_id = $this->user->id;
        $model->type = $this->type;
        $model->amount = $this->amount;
        $model->description = $this->description;
        $model->payload = $this->payload;
        $model->save();

        if (method_exists($this, 'sendTransactionNotification')) {
            if ($this->smsable())
                $this->sendTransactionNotification([
                    'mobile' => $this->user->mobile,
                    'body' => __($this->lang(), ['amount' => $this->amount])
                ]);
        }
        return $model;
    }


    function getConfig()
    {
        return config('transaction.' . $this->type);
    }

    function smsable()
    {
        return config('transaction.' . $this->type . '.sms');
    }

    function lang()
    {
        return config('transaction.' . $this->type . '.lang');
    }
}