<?php

namespace App\Services;

use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderService
{
    public function order(Request $request)
    {
        $time1 = Carbon::parse('16:00');
        $time2 = Carbon::parse('18:00');
        $totalPrice = 0;
        $flagLtTime1 = false;
        $flagGteTime1 = false;

        foreach($request->order as $order) {
            $time = Carbon::parse($order['time']);
            if ($time->lt($time1)) {
                $totalPrice += $order['quantity'] * 490;
                $flagLtTime1 = true;
            } elseif ($time->gte($time1) && $time->lt($time2)) {
                $totalPrice += $order['quantity'] * 290;
                $flagGteTime1 = true;
            } else {
                $totalPrice += $order['quantity'] * 490;
            }
        }

        if (filter_var($request->hasVoucher, FILTER_VALIDATE_BOOLEAN)) {
            $totalPrice -= $flagLtTime1 ? 390 : ($flagGteTime1 ? 190 : 390);
        }

        return $totalPrice;
    }
}
