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
        $response = $this->post('/api/pix',[
            'amount'=> 10050,
            'paymentId'=> 'PCC-0000001223'
        ]);

        $response->assertStatus(200);
    }
}
