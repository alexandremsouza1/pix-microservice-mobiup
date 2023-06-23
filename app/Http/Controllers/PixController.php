<?php

namespace App\Http\Controllers;


use App\Services\PixService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class PixController extends BaseController
{

    protected $service;


    public function __construct(PixService $service)
    {
      $this->service = $service;
    }

    public function index() : JsonResponse
    {
        $pix = $this->service->getAll();
        $messageText = 'Pix retornado com sucesso!';
        $statusCode = 200;
        return response()->json(['data' => $pix,'message' => $messageText, 'status' => true], $statusCode);
    }



    public function create(Request $request): JsonResponse
    {
      $data = $request->all();
      $messageText = 'Pix criado com sucesso!';
      $statusCode = 200;
      try {
        $pix = $this->service->store($data);
        return response()->json(['data' => $pix, 'message' => $messageText, 'status' => true], $statusCode);
      } catch (Exception $e) {
        $statusCode = 400;
        $messageText = 'Dados incorretos.';
        return response()->json(['message' => $messageText, 'status' => false], $statusCode);
      }
    }
}
