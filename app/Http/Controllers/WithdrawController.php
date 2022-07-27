<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function withdraw(Request $request)
    {
        $time1 = Carbon::parse('8:45');
        $time2 = Carbon::parse('18:00');
        $fee = 110;

        if ($request->isVIP == 'true') {
            $fee = 0;
        } else {
            if (Carbon::now()->isSaturday() || Carbon::now()->isSunday()) {
                $fee = 110;
            } else {
                if (Carbon::now()->gte($time1) && Carbon::now()->lt($time2)) {
                    $fee = 0;
                }
            }
        }

        return view('withdraw', compact('fee'));
    }
}
