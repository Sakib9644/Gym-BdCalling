<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use Illuminate\Http\Request;

class ClassScheduleController extends Controller
{
    public function index()
    {
        $classes = ClassSchedule::with('trainer')->get();
        return response()->json($classes);
    }

  public function store(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'trainer_id' => 'required|exists:trainers,id', 
        'class_time' => 'required|date_format:H:i:s', // Expect only time
        'capacity' => 'required|integer|min:1', 
    ]);

    // Get the current date to combine with the class_time
    $currentDate = \Carbon\Carbon::now()->format('Y-m-d');
    // Combine current date with class time to create a full datetime
    $combinedClassTime = $currentDate . ' ' . $request->class_time;

    // Check how many classes the trainer has for the current day
    $classCount = ClassSchedule::where('trainer_id', $request->trainer_id)
        ->whereDate('class_time', $currentDate)
        ->count();

    // Check if the trainer has a class scheduled at the requested time
    $existingClass = ClassSchedule::where('trainer_id', $request->trainer_id)
        ->where('class_time', $combinedClassTime)
        ->first();

    // If the count exceeds 5, return an error response
    if ($classCount >= 5) {
        return response()->json(['message' => 'Trainer can only have a maximum of 5 classes per day.'], 400);
    }

    // If the trainer already has a class at the specified time, return an error response
    if ($existingClass) {
        return response()->json(['message' => 'Trainer already has a class scheduled at this time.'], 400);
    }

    // Check if the trainer is available at the requested time
    $availability = \App\Models\Trainer::find($request->trainer_id)->availability;

    // Decode the availability JSON if it's stored as a JSON string
    $availability = json_decode($availability, true);

    // Get the current day of the week
    $dayOfWeek = \Carbon\Carbon::now()->format('l'); // e.g., "Monday"

    // Check if the trainer is available today
    if (isset($availability[$dayOfWeek])) {
        // Get the available time range
        $timeRange = explode('-', $availability[$dayOfWeek]);
        $startTime = \Carbon\Carbon::createFromFormat('H:i', trim($timeRange[0]));
        $endTime = \Carbon\Carbon::createFromFormat('H:i', trim($timeRange[1]));
        $requestedTime = \Carbon\Carbon::createFromFormat('H:i:s', $request->class_time);

        // Check if the requested time is within the available range
        if ($requestedTime < $startTime || $requestedTime > $endTime) {
            return response()->json(['message' => 'Trainer is not available at this time.'], 400);
        }
    } else {
        return response()->json(['message' => 'Trainer is not available on this day.'], 400);
    }

    // Check for time conflicts (overlapping classes)
    $conflictingClass = ClassSchedule::where('trainer_id', $request->trainer_id)
        ->whereDate('class_time', $currentDate)
        ->where('class_time', '<=', $combinedClassTime)
        ->where('class_time', '>=', \Carbon\Carbon::parse($combinedClassTime)->subMinutes(30)) // Assuming classes can overlap by 30 minutes
        ->first();

    // If there's a conflict, return an error response
    if ($conflictingClass) {
        return response()->json(['message' => 'Trainer has a conflicting class at this time.'], 400);
    }

    // Create the new class schedule
    $class = new ClassSchedule();
    $class->trainer_id = $request->trainer_id;
    $class->class_time = $combinedClassTime; // Save the combined class time
    $class->capacity = $request->capacity;
    $class->save();

    // Return a custom success response
    return response()->json($class, 201);
}


    public function show($id)
    {
        $class = ClassSchedule::with('trainer')->findOrFail($id);
        return response()->json($class);
    }

    public function update(Request $request, $id)
    {
        $class = ClassSchedule::findOrFail($id);
        $class->trainer_id = $request->trainer_id;
        $class->name = $request->name;
        $class->class_time = $request->class_time;
        $class->capacity = $request->capacity;
        $class->save();

        return response()->json($class);
    }

    public function destroy($id)
    {
        $class = ClassSchedule::findOrFail($id);
        $class->delete();
        return response()->json(null, 204);
    }
}
