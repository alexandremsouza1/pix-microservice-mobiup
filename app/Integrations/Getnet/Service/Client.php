<?php

namespace App\Integrations\Getnet\Service;

use App\Integrations\Getnet\Models\Response as ModelsResponse;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;


class Client
{
    public $options;
    private $client;
    private $response;
    protected $url;
    /**
     * @var Settings
     */
    private $settings;

    public function __construct($settings)
    {
        $this->settings = $settings;
        $this->response = new ModelsResponse();
        $this->client = new GuzzleClient();

        $this->url = $this->settings['url'];
    }

    public function call(string $method, string $endPoint, $token, $data = null)
    {
        try {
            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ];

            $request = new Request($method, $this->settings['url'] . $endPoint, $headers, json_encode($data));

            return $this->handleApiReturn(
                $this->client->sendRequest($request)
            );
        } catch (\Exception $e) {
            return $this->handleApiError($e);
        }
    }


    private function handleApiReturn($response)
    {
        $return = null;
        $successCode = [200, 201, 204];
        if (\in_array($response->getStatusCode(), $successCode)) {
            $return = json_decode($response->getBody());
        }

        return $return;
    }

    private function handleApiError(ClientException $e): object
    {
        $response = $e->getResponse();
        $body = json_decode($response->getBody());
        $statusCode = $response->getStatusCode();

        $this->response->code = (int) $e->getCode();
        $this->response->status    = $statusCode;
        $this->response->detail    = $body->detail;
        $this->response->type      = $body->type;
        $this->response->title     = $body->title;
        $this->response->violacoes = $body->violacoes;
        $this->response->messages  = 'Erro: ' . $e->getMessage();


        return $this->response;
    }

    protected function getApiToken()
    {
        $headers = [
            'Content-type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Basic '. base64_encode($this->settings['client_id'] . ':' . $this->settings['secret'])
        ];
        $options = [
            'form_params' => [
                'scope' => 'oob',
                'grant_type' => 'client_credentials'
            ]
        ];
        $request = new Request('POST', $this->settings['url_token'], $headers);
        return $this->handleApiReturn(
            $this->client->sendAsync($request, $options)->wait()
        );
    }
}
