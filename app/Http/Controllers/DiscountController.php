<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscountRequest;
use App\Services\DiscountService;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    protected $discountService;

    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    public function discount(Request $request)
    {
        if (!ctype_digit($request->quantity)) {
            return view('discount')->with('error', 'Wrong product quantity');
        }
        $percent = $this->discountService->discount($request);

        return view('discount', compact('percent'));
    }
}
