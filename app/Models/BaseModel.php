<?php

namespace App\Models;

use Illuminate\Support\Facades\Validator;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

/**
 * Class Base
 * @package App\Models
 * @property string $_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
abstract class BaseModel extends Eloquent
{
    const PRIMARY_KEY       = '_id';
    protected $connection   = 'mongodb';
    protected $rules        = [];


    /**
     * Timestamp field
     *
     * @var array
     */
    protected $dates =  [
      'created_at', 'updated_at', 'deleted_at'
    ];


    protected $casts = [
      '_id' => 'string',
    ];

    /**
     * @param $data
     * @return bool
     */
    public function validate($data)
    {
        if (!$data) {
          return false;
        }

        $v = Validator::make($data, $this->rules);
        $v->validate();
        if ($v->fails()) {
          return false;
        }
        return true;
    }
}
