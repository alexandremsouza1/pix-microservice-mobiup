<?php

namespace App\Http\Controllers;


use App\Services\PixService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class PixController extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Laravel OpenApi Demo Documentation",
     *      description="L5 Swagger OpenApi description",
     *      @OA\Contact(
     *          email="admin@admin.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Demo API Server"
     * )

     *
     * @OA\Tag(
     *     name="Projects",
     *     description="API Endpoints of Projects"
     * )
     */
    protected $service;


    public function __construct(PixService $service)
    {
      $this->service = $service;
    }
    /**
     * @OA\Get(
     *      path="/api/pix",
     *      operationId="getPixList",
     *      tags={"Pix"},
     *      summary="Get list of pix registered",
     *      description="Returns list of pix registered",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/PixResource")
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
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
        $messageText = $e->getMessage();
        return response()->json(['message' => $messageText, 'status' => false], $statusCode);
      }
    }

    public function find($id): JsonResponse
    {
      $messageText = 'Pix '.$id.' encontrado com sucesso!';
      $statusCode = 200;
      try {
        $pix = $this->service->getById($id);
        return response()->json(['data' => $pix, 'message' => $messageText, 'status' => true], $statusCode);
      } catch (Exception $e) {
        $statusCode = 400;
        $messageText = $e->getMessage();
        Log::error($messageText);
        return response()->json(['message' => $messageText, 'status' => false], $statusCode);
      }
    }

    public function update(Request $request, $id) : JsonResponse
    {
      $data = $request->all();
      $messageText = 'Pix '.$id.' alterado com sucesso!';
      $statusCode = 200;
      try {
        $this->service->update($id,$data);
        return response()->json(['message' => $messageText, 'status' => true], $statusCode);
      } catch (Exception $e) {
        $statusCode = 400;
        $messageText = $e->getMessage();
        Log::error($messageText);
        return response()->json(['message' => $messageText, 'status' => false], $statusCode);
      }
    }
}
