<?php

namespace App\Http\Controllers;


use App\Services\PixService;

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



    public function create(Request $request) : JsonResponse
    {
        $validated = $request->validate([
          'amount' => 'required',
          'paymentId' => 'required',
       ]);
       $messageText = 'Pix criado com sucesso!';
       $statusCode = 200;

        $pix = $this->service->store($validated);

        return response()->json(['data' => $pix,'message' => $messageText, 'status' => true], $statusCode);
    }
}
