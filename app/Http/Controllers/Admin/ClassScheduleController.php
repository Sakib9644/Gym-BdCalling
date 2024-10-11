<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\Trainer;
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class ClassScheduleController extends Controller
{

    public function index()
    {
        $classes = ClassSchedule::with('trainer')->get();

        $classw = [];

        foreach ($classes as $class) {
            $startTime = \Carbon\Carbon::parse($class->class_time);
            $endTime = $startTime->copy()->addHours(2);

            $formattedClass = [
                'trainer_id' => $class->trainer->id ?? null,
                'class_time' => $startTime->format('Y-m-d H:i:s') . ' to ' . $endTime->format('H:i:s'),
                'trainer_name' => $class->trainer->user->name ?? 'N/A',
                'class_name' => $class->class_name,
                'capacity' => $class->capacity,
            ];

            $classw[] = $formattedClass;
        }

        return response()->json($classw);
    }


    public function store(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'trainer_id' => 'required|exists:trainers,id',
            'class_time' => 'required|date_format:Y-m-d H:i',
            'capacity' => 'required|integer|min:1|max:30',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $classTime = Carbon::parse($request->class_time);
        $endTime = $classTime->copy()->addHours(2);

        $trainer = Trainer::find($request->trainer_id);
        $availability = json_decode($trainer->availability, true);
        $maxClassesPerDay = $trainer->max_classes_per_day ?? 5;
        $minInterval = $trainer->min_interval_between_classes ?? 2;

        $classDate = $classTime->toDateString();
        if (!in_array($classDate, $availability)) {
            return response()->json(['error' => 'The trainer is not available on this day.'], 409);
        }

        if (
            ClassSchedule::where('trainer_id', $request->trainer_id)
            ->whereDate('class_time', $classDate)
            ->count() >= $maxClassesPerDay
        ) {
            return response()->json([
                'error' => "A trainer can only schedul
                e a maximum of $maxClassesPerDay classes per day."
            ], 409);
        }

        if (ClassSchedule::where('trainer_id', $request->trainer_id)
            ->whereBetween('class_time', [$classTime, $endTime])
            ->orWhere(function ($query) use ($classTime, $endTime, $request) {
                $query->where('trainer_id', $request->trainer_id)
                    ->whereBetween(DB::raw("class_time + INTERVAL 2 HOUR"), [$classTime, $endTime]);
            })
            ->exists()
        ) {
            return response()->json(['error' => 'This class time conflicts with an existing class for this trainer.'], 409);
        }


        $class = ClassSchedule::create([
            'trainer_id' => $request->trainer_id,
            'class_time' => $request->class_time,
            'capacity' => $request->capacity,
            'class_name' => $request->class_name,
        ]);

        return response()->json([
            'class_time' => $classTime->format('Y-m-d H:i:s') . ' to ' . $endTime->format('H:i:s'),
        ]);
    }





    public function show($id)
    {
        $class = ClassSchedule::with('trainer')->findOrFail($id);
        return response()->json($class);
    }

    public function update(Request $request, $id)
    {
        $class = ClassSchedule::findOrFail($id);

        $classTime = \Carbon\Carbon::parse($request->class_time);
        $endTime = $classTime->copy()->addHours(2);

        $conflictExists = ClassSchedule::where('trainer_id', $class->trainer_id)
            ->where('id', '!=', $id)
            ->where(function ($query) use ($classTime, $endTime) {
                $query->whereBetween('class_time', [$classTime, $endTime])
                    ->orWhereBetween(DB::raw('class_time + INTERVAL 2 HOUR'), [$classTime, $endTime]);
            })
            ->exists();

        if ($conflictExists) {
            return response()->json(['error' => 'This class time conflicts with an existing class.'], 409);
        }

        $class->class_time = $classTime;
        $class->capacity = $request->capacity;
        $class->save();

        return response()->json([
            'class_time' => $classTime->format('Y-m-d H:i:s') . ' to ' . $endTime->format('H:i:s'),
            'capacity' => $class->capacity
        ]);
    }



    public function destroy($id)
    {
        $class = ClassSchedule::findOrFail($id);
        $class->delete();
        return response()->json(null, 204);
    }
}
