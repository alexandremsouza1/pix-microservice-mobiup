<?php

namespace Tests\Feature;

use App\Sdkpayment\Itau\Service\Factory;
use Tests\TestCase;

class ItauPixTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreatePix()
    {
        $factory = new Factory();

        $info = [
            "calendario" => [
                "expiracao" => 259200
            ],
            "devedor" => [
                "cpf" => '09852465619',
                "nome" => "Empresa de Serviços SA"
            ],
            "valor" => [
                "original" => 123.45
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

        $result = $factory->build($info);
        $result->image = ( new \chillerlan\QRCode\QRCode)->render($result->pixCopiaECola);
        $this->assertEquals('',json_encode($result));
    }
}
