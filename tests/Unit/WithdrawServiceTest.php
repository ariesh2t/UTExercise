<?php

namespace Tests\Unit;

use App\Services\WithdrawService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tests\TestCase;

class WithdrawServiceTest extends TestCase
{
    protected $serviceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->serviceMock = new WithdrawService();
    }

    public function tearDown(): void
    {
        unset($this->serviceMock);
        parent::tearDown();
    }

    public function test_with_vip_customer()
    {
        $request = new Request([
            'isVIP' => 'true'
        ]);

        $result = $this->serviceMock->withdraw($request);
        $this->assertEquals(0, $result);
    }

    public function test_is_holiday()
    {
        $knownDate = Carbon::create(2021, 4, 30);
        Carbon::setTestNow($knownDate);
        $this->funtion_test_with_no_vip_customer(110);
    }

    public function test_is_weekend()
    {
        $knownDate = Carbon::create(2022, 7, 24);
        Carbon::setTestNow($knownDate);
        $this->funtion_test_with_no_vip_customer(110);
    }

    public function test_is_weekday_from_8h45_to_18h()
    {
        $knownDate = Carbon::create(2022, 7, 27, 10, 0, 0);
        Carbon::setTestNow($knownDate);
        $this->funtion_test_with_no_vip_customer(0);
    }
    
    public function test_is_weekday_exactly_8h45()
    {
        $knownDate = Carbon::create(2022, 7, 27, 8, 45, 0);
        Carbon::setTestNow($knownDate);
        $this->funtion_test_with_no_vip_customer(0);
    }

    public function test_is_weekday_exactly_18h()
    {
        $knownDate = Carbon::create(2022, 7, 27, 18, 0, 0);
        Carbon::setTestNow($knownDate);
        $this->funtion_test_with_no_vip_customer(110);
    }

    public function test_is_weekday_with_less_than_8h45()
    {
        $knownDate = Carbon::create(2022, 7, 27, 8, 0, 0);
        Carbon::setTestNow($knownDate);
        $this->funtion_test_with_no_vip_customer(110);
    }

    public function test_is_weekday_with_greater_than_18h()
    {
        $knownDate = Carbon::create(2022, 7, 27, 19, 0, 0);
        Carbon::setTestNow($knownDate);
        $this->funtion_test_with_no_vip_customer(110);
    }

    public function funtion_test_with_no_vip_customer($fee)
    {
        $request = new Request([
            'isVIP' => 'false'
        ]);

        $result = $this->serviceMock->withdraw($request);
        $this->assertEquals($fee, $result);
    }
}
