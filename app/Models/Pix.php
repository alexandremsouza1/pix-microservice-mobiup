<?php

namespace App\Models;


use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Pix extends BaseModel
{

    use SoftDeletes;

    protected $collection = 'pix';
    /**
    * Timestamp field
    *
    * @var array
    */
    protected $dates =  [
        'created_at', 'updated_at','deleted_at'
    ];


    protected $fillable = [
        'amount','paymentId','copyAndPaste', 'customer','qrCode','expireAt'
    ];

    /**
     * Basic rule of database
     *
     * @var array
     */
    protected $rules = [
        'amount'       => 'required|int',
        'paymentId'    => 'required|string',
        'customer'     => 'required',
        'copyAndPaste' => 'required|string',
        'qrCode'       => 'required|string',
        'expireAt'     => 'required|string'
    ];


}