<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\Trainer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class AClassScheduleController extends Controller
{
    public function index()
    {
        $classes = ClassSchedule::all();

        return view('frontend.admin.classseschudle.index', compact('classes'));
    }

    // Show the form for creating a new class schedule
    public function create()
    {
        return view('frontend.admin.classseschudle.create');
    }

    // Store a newly created class schedule
    public function store(Request $request)
{
    $validator = FacadesValidator::make($request->all(), [
        'trainer_id' => 'required|exists:trainers,id',
        'class_time' => 'required|date_format:Y-m-d H:i',
        'capacity' => 'required|integer|min:1|max:30',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $classTime = Carbon::parse($request->class_time);
    $endTime = $classTime->copy()->addHours(2);

    $trainer = Trainer::find($request->trainer_id);
    $availability = json_decode($trainer->availability, true);
    $maxClassesPerDay = $trainer->max_classes_per_day ?? 5;
    $minInterval = $trainer->min_interval_between_classes ?? 2;

    $classDate = $classTime->toDateString();
    if (!in_array($classDate, $availability)) {
        return redirect()->back()->withErrors(['error' => 'The trainer is not available on this day.'])->withInput();
    }

    if (
        ClassSchedule::where('trainer_id', $request->trainer_id)
        ->whereDate('class_time', $classDate)
        ->count() >= $maxClassesPerDay
    ) {
        return redirect()->back()->withErrors(['error' => "A trainer can only schedule a maximum of $maxClassesPerDay classes per day."])->withInput();
    }

    if (ClassSchedule::where('trainer_id', $request->trainer_id)
        ->whereBetween('class_time', [$classTime, $endTime])
        ->orWhere(function ($query) use ($classTime, $endTime, $request) {
            $query->where('trainer_id', $request->trainer_id)
                ->whereBetween(DB::raw("class_time + INTERVAL 2 HOUR"), [$classTime, $endTime]);
        })
        ->exists()
    ) {
        return redirect()->back()->withErrors(['error' => 'This class time conflicts with an existing class for this trainer.'])->withInput();
    }

    $class = ClassSchedule::create([
        'trainer_id' => $request->trainer_id,
        'class_time' => $request->class_time,
        'capacity' => $request->capacity,
        'class_name' => $request->class_name,
    ]);

    return redirect()->route('admin.classes.index')->with('success', 'Class schedule created successfully.');
}



    // Show the form for editing the specified class schedule
    public function edit($id)
    {
        $class = ClassSchedule::findOrFail($id);

        return view('frontend.admin.classseschudle.edit', compact('class'));
    }

    // Update the specified class schedule in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'class_time' => 'required|date',
            'trainer_id' => 'required|exists:trainers,id',
            'class_name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
        ]);

        $class = ClassSchedule::findOrFail($id);
        $class->update($request->all());

        return redirect()->route('class-schedule.index')->with('success', 'Class schedule updated successfully.');
    }
}
