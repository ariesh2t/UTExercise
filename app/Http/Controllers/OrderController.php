<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function order(Request $request)
    {
        foreach($request->order as $order) {
            if(!ctype_digit($order['quantity'])) {
                return view('order')->with('error', 'Wrong quantity!');
            }
        }
        $totalPrice = $this->orderService->order($request);

        return view('order', compact('totalPrice'));
    }
}
