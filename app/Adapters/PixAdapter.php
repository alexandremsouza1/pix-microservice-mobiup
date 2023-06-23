<?php

namespace App\Adapters;

use App\Interfaces\Adapters\PixAdapterInterface;

class PixAdapter implements PixAdapterInterface
{

    private $data;

    public function __construct($data)
    {
      $this->data = $data;
    }

    public function getPix(): array
    {
        $products = $this->adaptPix($this->data);

        return $products;
    }

    private function adaptPix(object $pixObject): array
    {
        // fazer as adaptações aqui
        return (array) $pixObject;
    }
}