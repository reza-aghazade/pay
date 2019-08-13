<?php
/**
 * Created by PhpStorm.
 * User: mohsen1
 * Date: 10/18/18
 * Time: 10:06 PM
 */

return
    [
        'setting' => [
            'default' => 'zarinpal',
            'min_amount' => 100
        ],
        'gateways' => [
            'zarinpal' => [
                'id' => 1,
                'name' => 'زرین پال',
                'status' => 'enable',//enable or disable
                'type' => 'online', //online or sms
                'logo' => 0,//logo file id
                'request_url' => 'https://www.zarinpal.com/pg/services/WebGate/wsdl',
                'pay_url' => 'https://www.zarinpal.com/pg/StartPay',
                'verification_url' => 'https://www.zarinpal.com/pg/services/WebGate/wsdl',
                'merchant_id' => '6f5ed1c8-dbba-11e6-a7d5-000c295eb8fc',
                'class' => Limito\Pay\Payment\Bank\Banks\Zarinpal::class
            ]
        ]
    ];
