<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ClassSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ABookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('trainee_id', auth()->user()->id)
            ->get();

        return view('frontend.admin.trainee.booking', compact('bookings'));
    }

    public function create()
    {
        return view('frontend.admin.trainee.booking_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:class_schedules,id',
        ]);

        $classSchedule = ClassSchedule::findOrFail($request->class_id);

        if ($classSchedule->capacity <= 0) {
            return redirect()->back()->withErrors(['error' => 'Class is fully booked.'])->withInput();
        }

        $classTime = \Carbon\Carbon::parse($classSchedule->class_time);
        $endTime = $classTime->copy()->addHours(2);

        $conflict = Booking::where('trainee_id', auth()->user()->id)
            ->whereBetween('booking_time', [$classTime, $endTime])
            ->orWhereBetween(DB::raw('booking_time + INTERVAL 2 HOUR'), [$classTime, $endTime])
            ->exists();

        if ($conflict) {
            return redirect()->back()->withErrors(['error' => 'This class time conflicts with an existing booking.'])->withInput();
        }

        DB::transaction(function () use ($classSchedule, $classTime) {
            Booking::create([
                'trainee_id' => auth()->user()->id,
                'class_id' => $classSchedule->id,
                'booking_time' => $classTime,
            ]);

            $classSchedule->decrement('capacity');
        });

        return redirect()->route('trainee.bookings.index')->with('success', 'Class booked successfully.');
    }

    public function destroy($id)
{
    $booking = Booking::findOrFail($id);
    
    // Check if the booking belongs to the authenticated trainee
    if ($booking->trainee_id !== auth()->user()->id) {
        return redirect()->route('trainee.bookings.index')->withErrors('You do not have permission to delete this booking.');
    }

    $booking->delete();

    return redirect()->route('trainee.bookings.index')->with('success', 'Booking deleted successfully.');
}

}
