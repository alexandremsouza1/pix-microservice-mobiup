<?php


return [
  'url' => env('ITAU_URL',''), 
  'url_token' => env('ITAU_TOKEN_URL',''), 
  'client_id' => env('ITAU_CLIENT_ID',''),
  'secret' => env('ITAU_CLIENT_SECRET',''),
  'certs' => array(
      'crt' => storage_path('app/certs/itau/ARQUIVO_CERTIFICADO.crt'),
      'key' => storage_path('app/certs/itau/ARQUIVO_CHAVE_PRIVADA.key')
  ),
];