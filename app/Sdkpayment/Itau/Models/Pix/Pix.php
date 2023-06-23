<?php

namespace App\Sdkpayment\Itau\Models\Pix;

class Pix
{
    /**
     * @var string Chave DICT do recebedor
     */
    public $chave;

    /**
     * @var Location Estrutura com informações do identificador da localização do payload.
     */
    public $loc;

    /**
     * @var Calendar Os campos aninhados sob o identificador calendário e que organizam informações a respeito de controle de tempo da cobrança
     */
    public $calendario;

    /**
     * @var Debtor Devedor da cobrança
     * Os campos aninhados sob o objeto devedor são opcionais e identificam o devedor, ou seja, a pessoa ou a instituição a quem a cobrança está endereçada.
     * Não identifica, necessariamente, quem irá efetivamente realizar o pagamento.
     * (um CPF pode ser o devedor de uma cobrança, mas pode acontecer de outro CPF realizar, efetivamente, o pagamento do documento)
     */
    public $devedor;

    /**
     * @var Value Estrutura com valores monetários referentes a cobrança do documento.
     * Todos os campos que indicam valores monetários obedecem ao formato do ID 54 da especificação EMV/BR Code para QR Codes.
     * O separador decimal é o caractere ponto.
     * Não é aplicável utilizar separador de milhar.
     * Exemplos de valores aderentes ao padrão: “0.00”, “1.00”, “123.99”, “123456789.23”
     */
    public $valor;

    /**
     * @var string <= 140 characters
     * O campo solicitacaoPagador, determina um texto a ser apresentado ao pagador para que ele possa digitar uma informação correlata, em formato livre, a ser enviada ao recebedor
     * O campo está limitado a 140 caracteres.
     */
    public $solicitacaoPagador;

    /**
     * @var array <=50 > Cada respectiva informação adicional contida na lista (nome e valor) deve ser apresentada ao pagador
     */
    public $infoAdicionais;


    public function build($data)
    {
        $this->devedor = isset($data['devedor']) ? $data['devedor'] : null;
        $this->valor = isset($data['valor']) ? $data['valor'] : null;
        $this->loc = isset($data['loc']) ? $data['loc'] : null;
        $this->chave = isset($data['chave']) ? $data['chave'] : null;
        $this->solicitacaoPagador = isset($data['solicitacao_pagador']) ? $data['solicitacao_pagador'] : null;
        $this->calendario = isset($data['calendario']) ? $data['calendario'] : null;
        $this->infoAdicionais = isset($data['info_adicionais']) ? $data['info_adicionais'] : null;

        return $this;
    }
}