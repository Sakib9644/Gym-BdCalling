<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class ABookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('classSchedule', 'trainee') // Assuming relationships are defined
            ->where('trainee_id', auth()->user()->id)
            ->get();

        return view('frontend.admin.trainee.booking',compact('bookings'));
    }
    public function create()
    {

        return view('frontend.admin.trainee.booking_create');
    }
}
