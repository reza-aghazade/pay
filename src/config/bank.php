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
            ],
            'parsian' => [
                'id' => 2,
                'name' => 'پارسیان',
                'status' => 'enable',//enable or disable
                'type' => 'online', //online or sms
                'logo' => 0,//logo file id
                'request_url' => 'https://pec.shaparak.ir/NewIPGServices/Sale/SaleService.asmx?wsdl',
                'pay_url' => 'https://pec.shaparak.ir/NewIPG',
                'verification_url' => 'https://pec.shaparak.ir/NewIPGServices/Confirm/ConfirmService.asmx?WSDL',
                'merchant_id' => '1212121212',
                'class' => Limito\Pay\Payment\Bank\Banks\Parsian::class
            ],
            'mellat' => [
                'id' => 3,
                "username" => "SAMPLE1212",
                "password" => 23121233,
                'name' => 'ملت',
                'status' => 'enable',//enable or disable
                'type' => 'online', //online or sms
                'logo' => 0,//logo file id
                'request_url' => 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl',
                'pay_url' => 'https://bpm.shaparak.ir/pgwchannel/payment.mellat',
                'verification_url' => 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl',
                'merchant_id' => '121212121212',
                'class' => Limito\Pay\Payment\Bank\Banks\Mellat::class
            ],
            'payping' => [
                'id' => 4,
                'name' => 'پی پینگ',
                'status' => 'enable',//enable or disable
                'type' => 'online', //online or sms
                'logo' => 0,//logo file id
                'request_url' => 'https://api.payping.ir/v1/',
                'pay_url' => 'https://api.payping.ir/v1/',
                'verification_url' => 'https://api.payping.ir/v1/',
                'merchant_id' => '121212121212',
                'class' => Limito\Pay\Payment\Bank\Banks\Payping::class
            ]
        ]
    ];
