<?php

namespace Tests\Unit;

use App\Http\Controllers\OrderController;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Tests\ControllerTestCase as TestCase;
use Mockery as m;

class OrderTest extends TestCase
{
    protected $controllerMock;
    protected $serviceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->serviceMock = m::mock($this->app->make(OrderService::class));
        $this->controllerMock = new OrderController($this->serviceMock);
    }

    public function tearDown(): void
    {
        m::close();
        unset($this->controllerMock);
        parent::tearDown();
    }

    public function test_quantity_is_not_a_positive_integer()
    {
        $request = new Request([
            'order' => [
                [
                    'quantity' => "3.5",
                    'time' => '10:00'
                ]
            ],
            'hasVoucher' => "true",
        ]);

        $result = $this->controllerMock->order($request);
        $this->assertViewResponse($result, 'order', ['error']);
    }

    public function test_quantity_is_a_positive_integer()
    {
        $request = new Request([
            'order' => [
                [
                    'quantity' => "3",
                    'time' => '10:00'
                ]
            ],
            'hasVoucher' => "true",
        ]);

        $this->serviceMock->shouldReceive('order')->andReturn(490);

        $result = $this->controllerMock->order($request);
        $this->assertViewResponse($result, 'order', ['totalPrice']);
    }
}
