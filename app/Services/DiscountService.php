<?php

namespace App\Services;

use Illuminate\Http\Request;

class DiscountService
{
    public function discount(Request $request)
    {
        $hasTshirt = filter_var($request->hasTshirt, FILTER_VALIDATE_BOOLEAN);
        $hasTie = filter_var($request->hasTie, FILTER_VALIDATE_BOOLEAN);

        $percent = 0;
        if ($request->quantity >=7) {
            $percent += 7;
        }
        if ($hasTshirt && $hasTie) {
            $percent += 5;
        }

        return $percent;
    }
}
