<?php

namespace App\Adapters;

use App\Adapters\Interfaces\PixAdapterInterface;

class PixItauAdapter implements PixAdapterInterface
{

    const INFO = [
        "calendario" => [
            "expiracao" => 259200
        ],
        "devedor" => [],
        "valor" => [
            "original" => 0
        ],
        "chave" => "00074569000100",
        "solicitacaoPagador" => "Informar cartão fidelidade",
        "infoAdicionais" => [
            [
                "nome" => "Campo 1",
                "valor" => "Informação Adicional1"
            ],
            [
                "nome" => "Campo 2",
                "valor" => "Informação Adicional2"
            ],
        ]
    ];


    public function getAdaptPix($data): array
    {
        $pixAdaptIntegration = $this->adaptIntegrationPix($data);
        $pixConverted        = $this->adaptPix($pixAdaptIntegration);

        return $pixConverted;
    }

    private function adaptIntegrationPix($data): array
    {
        $object = new \stdClass();

        foreach (self::INFO as $key => $value)
        {
            $object->$key = $value;
        }

        $valor = $data['amount'] / 100;
        $object->valor = new \stdClass();
        $object->valor->original = number_format($valor, 2, '.', '');

        $object->nome = $data['customer']['firstName'];

        $object->devedor = new \stdClass();
        if (strlen($data['customer']['document']) == 11) {
            $object->devedor->cpf = $data['customer']['document'];
        } else {
            $object->devedor->cnpj = $data['customer']['document'];
        }
        $object->devedor->nome = $data['customer']['firstName'];


        return (array) $object;
    }

    private function adaptPix($data): array
    {
        
        return $data;
    }
}