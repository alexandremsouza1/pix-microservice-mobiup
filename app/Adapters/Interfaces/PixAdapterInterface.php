<?php

namespace App\Adapters\Interfaces;

use App\Models\Pix;

interface PixAdapterInterface
{
    public function getAdaptPix($data): array;
}