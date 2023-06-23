<?php

namespace App\Models;


use Jenssegers\Mongodb\Eloquent\SoftDeletes as SoftDeletes;

class Pix extends BaseModel
{

    use SoftDeletes;
    /**
    * Timestamp field
    *
    * @var array
    */
    protected $dates =  [
        'created_at', 'updated_at','deleted_at'
    ];


    protected $fillable = [
        'amount','paymentId','copyAndPaste', 'image','qrCode','expireAt'
    ];

    /**
     * Basic rule of database
     *
     * @var array
     */
    protected $rules = [
        'amount'       => 'required|int',
        'paymentId'    => 'required|string',
        'customer'     => 'required|object',
        'copyAndPaste' => 'required|string',
        'image'        => 'required|string',
        'qrCode'       => 'required|string',
        'expireAt'     => 'required|string'
    ];


}