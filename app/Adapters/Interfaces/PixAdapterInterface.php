<?php

namespace App\Adapters\Interfaces;

interface PixAdapterInterface
{
    public function getAdaptPix($data): array;
}