<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PixControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRequestCreatePix()
    {

        $body = '{
            "amount": "10050",
            "paymentId": "PCC-0000001223",
            "customer": {
              "document": "22776171000140",
              "firstName": "Razão Social da Empresa"
            }
          }';
        $body = json_decode($body,true);
        $response = $this->post('/api/pix',$body);

        $response->assertStatus(200);
    }

    public function testRequestFindPix()
    {
        $id = '8787bc06a07f42dfaa128bc0ab676e92';
        $response = $this->get('/api/pix/'.$id);

        $response->assertStatus(200);
    }

    public function testRequestChangePix()
    {
        $id = "8787bc06a07f42dfaa128bc0ab676e92";
        $response = $this->patch('/api/pix/'.$id,['status' => 'DENIED']);

        $response->assertStatus(200);
    }
}
