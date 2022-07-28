<?php

namespace Tests\Unit;

use App\Http\Controllers\WithdrawController;
use App\Services\WithdrawService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tests\ControllerTestCase as TestCase;
use Mockery as m;

class WithDrawTest extends TestCase
{
    protected $controllerMock;
    protected $withdrawServiceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->withdrawServiceMock = m::mock($this->app->make(WithdrawService::class));
        $this->controllerMock = new WithdrawController($this->withdrawServiceMock);
    }

    public function tearDown(): void
    {
        m::close();
        unset($this->controllerMock);
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function test_withdraw_funtion()
    {
        $request = new Request([
            'isVIP' => 'true'
        ]);
        $this->withdrawServiceMock
        ->shouldReceive('withdraw')
        ->andReturn(0);

        $result = $this->controllerMock->withdraw($request);
        $this->assertViewResponse($result, 'withdraw', ['fee']);
    }
}
