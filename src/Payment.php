<?php
/**
 * Created by PhpStorm.
 * User: mohsen1
 * Date: 10/18/18
 * Time: 5:40 PM
 */

namespace Limito\Pay;


use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{ 
    protected $fillable = ["user_id" , "bank_id" , "amount" , "name" , "description" , "bank_result" , "payload" ,  "status" , "paid_at"];
}
