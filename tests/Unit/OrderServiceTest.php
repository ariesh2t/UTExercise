<?php

namespace Tests\Unit;

use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    protected $serviceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->serviceMock = new OrderService();
    }

    public function tearDown(): void
    {
        unset($this->serviceMock);
        parent::tearDown();
    }

    public function test_order_from_16_to_18h_with_voucher()
    {
        $request = new Request([
            'order' => [
                [
                    'time' => '17:00',
                    'quantity' => 2,
                ]
            ],
            'hasVoucher' => 'true',
        ]);

        $result = $this->serviceMock->order($request);
        $this->assertEquals(390, $result);
    }

    public function test_order_from_16_to_18h_without_voucher()
    {
        $request = new Request([
            'order' => [
                [
                    'time' => '17:00',
                    'quantity' => 2,
                ]
            ],
            'hasVoucher' => 'false',
        ]);

        $result = $this->serviceMock->order($request);
        $this->assertEquals(580, $result);
    }

    public function test_order_before_16h_with_voucher()
    {
        $request = new Request([
            'order' => [
                [
                    'time' => '15:00',
                    'quantity' => 2,
                ]
            ],
            'hasVoucher' => 'true',
        ]);

        $result = $this->serviceMock->order($request);
        $this->assertEquals(590, $result);
    }

    public function test_order_before_16h_without_voucher()
    {
        $request = new Request([
            'order' => [
                [
                    'time' => '15:00',
                    'quantity' => 2,
                ]
            ],
            'hasVoucher' => 'false',
        ]);

        $result = $this->serviceMock->order($request);
        $this->assertEquals(980, $result);
    }

    public function test_order_exactly_16h_with_voucher()
    {
        $request = new Request([
            'order' => [
                [
                    'time' => '16:00',
                    'quantity' => 2,
                ]
            ],
            'hasVoucher' => 'true',
        ]);

        $result = $this->serviceMock->order($request);
        $this->assertEquals(390, $result);
    }

    public function test_order_exactly_16h_without_voucher()
    {
        $request = new Request([
            'order' => [
                [
                    'time' => '16:00',
                    'quantity' => 2,
                ]
            ],
            'hasVoucher' => 'false',
        ]);

        $result = $this->serviceMock->order($request);
        $this->assertEquals(580, $result);
    }

    public function test_order_from_18h_onwards_with_voucher()
    {
        $request = new Request([
            'order' => [
                [
                    'time' => '18:00',
                    'quantity' => 2,
                ]
            ],
            'hasVoucher' => 'true',
        ]);

        $result = $this->serviceMock->order($request);
        $this->assertEquals(590, $result);
    }

    public function test_order_from_18h_onwards_without_voucher()
    {
        $request = new Request([
            'order' => [
                [
                    'time' => '18:00',
                    'quantity' => 2,
                ]
            ],
            'hasVoucher' => 'false',
        ]);

        $result = $this->serviceMock->order($request);
        $this->assertEquals(980, $result);
    }

    public function test_order_from_before_16h_to_after_18h_with_voucher()
    {
        $request = new Request([
            'order' => [
                [
                    'time' => '15:00',
                    'quantity' => 2,
                ],
                [
                    'time' => '17:00',
                    'quantity' => 3,
                ],
                [
                    'time' => '19:00',
                    'quantity' => 3,
                ],
            ],
            'hasVoucher' => 'true',
        ]);

        $result = $this->serviceMock->order($request);
        $this->assertEquals(2930, $result);
    }

    public function test_order_from_before_16h_to_after_18h_without_voucher()
    {
        $request = new Request([
            'order' => [
                [
                    'time' => '15:00',
                    'quantity' => 2,
                ],
                [
                    'time' => '17:00',
                    'quantity' => 3,
                ],
                [
                    'time' => '19:00',
                    'quantity' => 3,
                ],
            ],
            'hasVoucher' => 'false',
        ]);

        $result = $this->serviceMock->order($request);
        $this->assertEquals(3320, $result);
    }

}
