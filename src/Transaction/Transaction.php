<?php
/**
 * Created by PhpStorm.
 * User: mohsen1
 * Date: 10/19/18
 * Time: 10:41 AM
 */

namespace Limito\Pay\Transaction;


class Transaction extends BaseTransaction
{
    use TransactionNotifier;


    function __construct($type)
    {
        $this->type = $type;
    }

    static function type($type)
    {
        return new Transaction($type);
    }


}