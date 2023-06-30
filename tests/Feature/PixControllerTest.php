<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PixControllerTest extends TestCase
{
    protected static $initialized = FALSE;
    protected static $idPix = null;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp() :void
    {
        parent::setUp();
        if (!self::$initialized) {
            // Do something once here for _all_ test subclasses.
            self::$initialized = TRUE;
        }
    }

    //success
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

        self::$idPix = json_decode($response->getContent(),true)['data']['_id'];

        $response->assertStatus(200);
    }

    public function testRequestFindPix()
    {
        $response = $this->get('/api/pix/'.self::$idPix);

        $response->assertStatus(200);
    }

    public function testRequestChangePix()
    {
        $response = $this->patch('/api/pix/'.self::$idPix,['status' => 'DENIED']);

        $response->assertStatus(200);
    }

    public function testRequestGetAllPix()
    {
        $response = $this->get('/api/pix/');

        $response->assertStatus(200);
    }

    //error
    public function testFailRequestCreatePix()
    {

        $body = '{
            "amount": "abc",
            "paymentId": "PCC-0000001223",
            "customer": {
              "document": "22776171000140",
              "firstName": "Razão Social da Empresa"
            }
          }';
        $body = json_decode($body,true);
        $response = $this->post('/api/pix',$body);

        //self::$idPix = json_decode($response->getContent(),true)['data']['_id'];

        $response->assertStatus(500);
    }

    public function testFailRequestFindPix()
    {
        $response = $this->get('/api/pix/1');

        $response->assertStatus(404);
    }

    public function testFailRequestChangePix()
    {
        $response = $this->patch('/api/pix/1',['status' => 'DENIED']);

        $response->assertStatus(404);
    }
}
