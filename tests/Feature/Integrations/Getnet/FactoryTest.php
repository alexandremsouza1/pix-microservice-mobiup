<?php

namespace Tests\Controllers\Feature\Integrations\Getnet;

use App\Integrations\Getnet\Service\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FactoryTest extends TestCase
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
    public function testFactoryPixGetnet()
    {

      $factory = new Factory();
      $result = $factory->build([
          'pix' => [
              'key' => '60701190000104',
              'payer_request' => 'Informar cartão fidelidade',
              'calendar' => [
                  'expiration' => '3600'
              ],
              'debtor' => [
                  'name' => 'Empresa de Serviços SA',
                  'document' => '12345678000195'
              ],
              'value' => [
                  'original' => '12345',
              ],
              'additional_information' => [
                  ['name' => 'Campo 1', 'value' => 'Informação Adicional1'],
                  ['name' => 'Campo 2', 'value' => 'Informação Adicional2']
              ]
          ]
      ]);

        $this->assertEquals([],$result);
    }

    }
