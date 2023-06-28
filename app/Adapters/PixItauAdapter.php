<?php

namespace App\Adapters;

use App\Adapters\Interfaces\PixAdapterInterface;
use App\Integrations\Itau\Service\Factory;
use App\Models\Pix;
use Carbon\Carbon;

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
        $factory = new Factory();
        $resultPixAdaptIntegration = $factory->build($pixAdaptIntegration);
        return $this->adaptPix($data,$resultPixAdaptIntegration);
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

    private function adaptPix($origin,$data): array
    {
        return [
            '_id' => $data->txid,
            'status' => $this->getRealStatus($data->status),
            'amount' => $origin['amount'],
            'paymentId' => $origin['paymentId'],
            'customer' => $origin['customer'],
            'copyAndPaste'=> $data->pixCopiaECola, 
            'qrCode' => ( new \chillerlan\QRCode\QRCode)->render($data->pixCopiaECola),
            'expireAt' =>  $this->calculateExpirationPixDate($data->calendario)
        ];
    }

    private function calculateExpirationPixDate(Object $calendar) : string
    {
        // Extract the creation date and expiration time from the provided data
        $criacao = Carbon::parse($calendar->criacao);
        $expiracaoInMilliseconds = $calendar->expiracao;

        // Calculate the expiration date
        $expiracao = $criacao->addMilliseconds($expiracaoInMilliseconds);

        // Format the expiration date as desired (e.g., to a specific format)
        return $expiracao->format('Y-m-d\TH:i:s.u\Z');
    }

    private function getRealStatus($status)
    {
        $result = 'PENDING';
        switch ($status) {
            case 'ATIVA':
                $result = 'WAITING';
                break;
            case 'CONCLUIDA':
                $result = 'APPROVED';
                break;
            case 'REMOVIDA_PELO_PSP':
                 $result = 'EXPIRED';
                break;
            case 'REMOVIDA_PELO_USUARIO_RECEBEDOR':
                 $result = 'EXPIRED';
                break;
        }
       return $result;
    }
}