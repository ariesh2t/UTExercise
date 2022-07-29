<?php

namespace Tests\Unit;

use App\Http\Controllers\DiscountController;
use App\Services\DiscountService;
use Illuminate\Http\Request;
use Tests\ControllerTestCase as TestCase;
use Mockery as m;

class DiscountTest extends TestCase
{
    protected $controllerMock;
    protected $serviceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->serviceMock = m::mock($this->app->make(DiscountService::class));
        $this->controllerMock = new DiscountController($this->serviceMock);
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
            'quantity' => "10.1",
            'hasTshirt' => "true",
            'hasTie' => "false",
        ]);

        $result = $this->controllerMock->discount($request);
        $this->assertViewResponse($result, 'discount', ['error']);
    }

    public function test_quantity_is_a_positive_integer()
    {
        $request = new Request([
            'quantity' => "10",
            'hasTshirt' => "true",
            'hasTie' => "false",
        ]);

        $this->serviceMock
        ->shouldReceive('discount')
        ->andReturn(7);

        $result = $this->controllerMock->discount($request);
        $this->assertViewResponse($result, 'discount', ['percent']);
    }
}
