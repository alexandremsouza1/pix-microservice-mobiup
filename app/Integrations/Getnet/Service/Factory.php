<?php

namespace App\Integrations\Getnet\Service;

use App\Integrations\Getnet\Models\Pix\Pix;
use Exception;

class Factory extends Client
{

    public function __construct()
    {
        $settings = config('getnet');
        parent::__construct($settings);
    }

    /**
     * @throws Exception
     */
    public function build(array $data)
    {
        $endpoint = 'v1/payments/qrcode/pix';
        $object = new Pix();
        return $this->register($data, 'POST', $endpoint);
    }

    public function register($data, $method, $endpoint)
    {
        $token = $this->getApiToken();
        return $this->call($method, $endpoint, $token->access_token, $data);
    }
}