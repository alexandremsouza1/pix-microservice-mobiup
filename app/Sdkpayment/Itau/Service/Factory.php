<?php

namespace App\Sdkpayment\Itau\Service;

use App\Sdkpayment\Itau\Models\Pix\Pix;
use Exception;

class Factory extends Client
{

    public function __construct()
    {
        $settings = config('itau');
        parent::__construct($settings);
    }

    /**
     * @throws Exception
     */
    public function build(array $data)
    {
        $endpoint = 'cob';
        $object = new Pix();
        return $this->register($data, 'POST', $endpoint);
    }

    public function register($data, $method, $endpoint)
    {
        $token = $this->getApiToken();
        return $this->call($method, $endpoint, $token->access_token, $data);
    }
}