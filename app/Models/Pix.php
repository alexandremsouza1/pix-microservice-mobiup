<?php

namespace App\Models;


use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes as SoftDeletes;

class Pix extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];


    protected $connection = 'mongodb';
    protected $collection = 'pix';


    protected $fillable = [
        'amount','paymentId','copyAndPaste', 'image','qrCode','expireAt'
    ];

}