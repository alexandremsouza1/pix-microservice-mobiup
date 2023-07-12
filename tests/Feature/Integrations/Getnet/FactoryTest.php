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
        'amount' => 100,
        'currency' => 'BRL',
        'order_id'=> 'DEV-1608748980',
        'customer_id' => '09852465619'
      ]);

        $this->assertEquals([],$result);
    }

    }
