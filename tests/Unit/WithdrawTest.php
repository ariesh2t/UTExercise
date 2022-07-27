<?php

namespace Tests\Unit;

use App\Http\Controllers\WithdrawController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tests\ControllerTestCase as TestCase;

class WithDrawTest extends TestCase
{
    protected $controllerMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->controllerMock = new WithdrawController();
    }

    public function tearDown(): void
    {
        unset($this->controllerMock);
        parent::tearDown();
    }

    public function test_withdraw_function_with_vip_customer()
    {
        $request = new Request([
            'isVIP' => 'true'
        ]);

        $result = $this->controllerMock->withdraw($request);

        $this->assertViewResponse($result, 'withdraw', ['fee']);
        $this->assertEquals(0, $result->getData()['fee']);
    }

    public function test_withdraw_function_with_no_vip_customer_and_is_weekend()
    {
        $knownDate = Carbon::create(2022, 7, 23);
        Carbon::setTestNow($knownDate);
        $request = new Request([
            'isVIP' => 'false'
        ]);

        $result = $this->controllerMock->withdraw($request);
        $this->assertViewResponse($result, 'withdraw', ['fee']);
        $this->assertEquals(110, $result->getData()['fee']);
    }

    public function test_withdraw_function_with_no_vip_customer_and_is_weekday_from_8h45_to_18h()
    {
        $knownDate = Carbon::create(2022, 7, 27, 10, 0, 0);
        Carbon::setTestNow($knownDate);
        $request = new Request([
            'isVIP' => 'false'
        ]);

        $result = $this->controllerMock->withdraw($request);
        $this->assertViewResponse($result, 'withdraw', ['fee']);
        $this->assertEquals(0, $result->getData()['fee']);
    }

    public function test_withdraw_function_with_no_vip_customer_and_is_weekday_with_remaining_time_frame()
    {
        $knownDate = Carbon::create(2022, 7, 27, 2, 0, 0);
        Carbon::setTestNow($knownDate);
        $request = new Request([
            'isVIP' => 'false'
        ]);

        $result = $this->controllerMock->withdraw($request);
        $this->assertViewResponse($result, 'withdraw', ['fee']);
        $this->assertEquals(110, $result->getData()['fee']);
    }
}
