<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Pix extends BaseModel
{
    /**
     * @OA\Schema(
     *     schema="PixResource",
     *     type="object",
     *     @OA\Property(property="amount", type="string"),
     *     @OA\Property(property="paymentId", type="string"),
     *     @OA\Property(property="copyAndPaste", type="string"),
     *     @OA\Property(property="customer", type="string"),
     *     @OA\Property(property="qrCode", type="string"),
     *     @OA\Property(property="expireAt", type="string")
     * )
     */
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
        '_id','status','amount','paymentId','copyAndPaste', 'customer','qrCode','expireAt'
    ];


    const TYPES_STATUS = ['PENDING','WAITING','EXPIRED','ERROR','APPROVED','DENIED']; 

    /**
     * Basic rule of database
     *
     * @var array
     */
    public function rules()
    {
        return [
            'status'       => ['required', Rule::in(self::TYPES_STATUS)],
            'amount'       => 'required|int',
            'paymentId'    => 'required|string',
            'customer'     => 'required',
            'copyAndPaste' => 'required|string',
            'qrCode'       => 'required|string',
            'expireAt'     => 'required|string'
        ];
    }


}