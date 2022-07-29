<?php

namespace Tests\Unit;

use App\Services\DiscountService;
use Illuminate\Http\Request;
use Tests\TestCase;

class DiscountServiceTest extends TestCase
{
    protected $serviceMock;

    public function setUp(): void
    {
        parent::setUp();
        $this->serviceMock = new DiscountService();
    }

    public function tearDown(): void
    {
        unset($this->serviceMock);
        parent::tearDown();
    }

    public function test_quantity_less_than_7_has_not_tshirt()
    {
        $request = new Request([
            'quantity' => '6',
            'hasTshirt' => 'false',
            'hasTie' => 'true',
        ]);

        $result = $this->serviceMock->discount($request);
        $this->assertEquals(0, $result);
    }

    public function test_quantity_less_than_7_has_tshirt_and_tie()
    {
        $request = new Request([
            'quantity' => '6',
            'hasTshirt' => 'true',
            'hasTie' => 'true',
        ]);

        $result = $this->serviceMock->discount($request);
        $this->assertEquals(5, $result);
    }

    public function test_quantity_exactly_7_has_not_tshirt_and_tie()
    {
        $request = new Request([
            'quantity' => '7',
            'hasTshirt' => 'false',
            'hasTie' => 'false',
        ]);

        $result = $this->serviceMock->discount($request);
        $this->assertEquals(7, $result);
    }

    public function test_quantity_greater_than_7_has_tshirt_and_no_tie()
    {
        $request = new Request([
            'quantity' => '8',
            'hasTshirt' => 'true',
            'hasTie' => 'false',
        ]);

        $result = $this->serviceMock->discount($request);
        $this->assertEquals(7, $result);
    }

    public function test_quantity_greater_than_7_has_tie_and_no_tshirt()
    {
        $request = new Request([
            'quantity' => '8',
            'hasTshirt' => 'false',
            'hasTie' => 'true',
        ]);

        $result = $this->serviceMock->discount($request);
        $this->assertEquals(7, $result);
    }

    public function test_quantity_greater_than_7_has_tie_and_tshirt()
    {
        $request = new Request([
            'quantity' => '8',
            'hasTshirt' => 'true',
            'hasTie' => 'true',
        ]);

        $result = $this->serviceMock->discount($request);
        $this->assertEquals(12, $result);
    }
}
