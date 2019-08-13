<?php
/**
 * Created by PhpStorm.
 * User: mohsen1
 * Date: 10/18/18
 * Time: 10:54 PM
 */

namespace Limito\Pay\Payment\Bank;


interface iBank
{

    function startPayment();

    function callback();
}