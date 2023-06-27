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
              "metadata": {
                "externalId": "CPF_CNPJ_OU_ID_NO_SISTEMA_PARCEIRO",
                "POSCode": "Point of sale code (codigo PV)"
              },
              "document": "22776171000140",
              "firstName": "Razão Social da Empresa",
              "lastName": "",
              "billingAddress": {
                "addressLine1": "123 Main Street",
                "addressLine2": "Apt 4B",
                "addressLine3": "",
                "city": "New York",
                "companyName": "ABC Corporation",
                "country": "US",
                "firstName": "John",
                "lastName": "Doe",
                "postalCode": "10001",
                "region": "NY"
              }
            },
            "provider": "santander"
          }';
        $body = json_decode($body,true);
        $response = $this->post('/api/pix',$body);

        $response->assertStatus(200);
    }
}
