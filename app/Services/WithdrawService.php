<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Cmixin\BusinessDay;

class WithdrawService
{
    public function withdraw(Request $request)
    {
        BusinessDay::enable('Carbon\Carbon');
        Carbon::setHolidaysRegion('vn');
        $time1 = Carbon::parse('8:45');
        $time2 = Carbon::parse('18:00');

        if ($request->isVIP == 'true') {
            return 0;
        }
        if (Carbon::now()->isWeekend() || Carbon::now()->isHoliday()) {
            return 110;
        }
        if (Carbon::now()->gte($time1) && Carbon::now()->lt($time2)) {
            return 0;
        }
        
        return 110;
    }
}
