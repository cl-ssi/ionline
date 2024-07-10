<?php

namespace App\Http\Controllers\HotelBooking;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HotelBooking\RoomBooking;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function DiscountSheet(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month', Carbon::now()->month);
        $status = $request->get('status');

        $roomBookings = RoomBooking::whereYear('start_date', $year)
            ->whereMonth('start_date', $month)
            ->when($status, function ($q) use ($status) {
                    return $q->where('status',$status);
                })
            ->get();

        return view('hotel_booking.reports.discount_sheet', compact('roomBookings'));
    }
}
