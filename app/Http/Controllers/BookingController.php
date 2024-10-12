<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ClassSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('classSchedule', 'trainee') // Assuming relationships are defined
            ->where('trainee_id', auth()->user()->id)
            ->get();

        return response()->json($bookings);
    }
    public function availableClasses()
    {
        dd('sdf');
        $classes = ClassSchedule::with('trainer')
            ->where('capacity', '>', 0) // Only show classes that have available spots
            ->get()
            ->map(function ($class) {
                $startTime = \Carbon\Carbon::parse($class->class_time);
                $endTime = $startTime->copy()->addHours(2);
                return [
                    'id' => $class->id,
                    'class_name' => $class->class_name,
                    'trainer_name' => $class->trainer->user->name ?? '',
                    'class_time' => $startTime->format('Y-m-d H:i:s') . ' to ' . $endTime->format('H:i:s'),
                    'capacity' => $class->capacity,
                ];
            });

        return response()->json($classes);
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:class_schedules,id',
        ]);

        $classSchedule = ClassSchedule::findOrFail($request->class_id);

        if ($classSchedule->capacity <= 0) {
            return response()->json(['error' => 'Class is fully booked.'], 409);
        }

        $classTime = \Carbon\Carbon::parse($classSchedule->class_time);
        $endTime = $classTime->copy()->addHours(2);

        $conflict= Booking::where('trainee_id', $request->trainer_id)
        ->whereBetween('booking_time', [$classTime, $endTime])
        ->orWhereBetween(DB::raw('booking_time + INTERVAL 2 HOUR'), [$classTime, $endTime])
        ->exists();


        if ($conflict) {
            return response()->json(['error' => 'This class time conflicts with an existing booking.'], 409);
        }

        $booking = Booking::create([
            'trainee_id' => auth()->user()->id,
            'class_id' => $classSchedule->id,
            'booking_time' => $classTime,
        ]);

        $classSchedule->decrement('capacity');

        return response()->json([
            'class_time' => $classTime->format('Y-m-d H:i:s') . ' to ' . $endTime->format('H:i:s'),
            'message' => 'class booked successfully'
        ]);
    }


    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->trainee_id !== auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        $classSchedule = $booking->classSchedule; // Assuming there's a relation defined
        $classSchedule->increment('capacity');

        $booking->delete();

        return response()->json(['message' => 'Booking cancelled successfully.']);
    }
}
