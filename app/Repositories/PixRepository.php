<?php

namespace App\Repositories;

use App\Models\Pix;
use Carbon\Carbon;

class PixRepository extends AbstractRepository
{

    public function __construct(Pix $model)
    {
        $this->model = $model;
    }
}
