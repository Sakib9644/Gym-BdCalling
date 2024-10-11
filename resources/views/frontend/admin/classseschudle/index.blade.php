@extends('layouts.layouts')

@section('content')
<div class="container p-5">
    <h1>Class Schedules</h1>

    <div class="mb-3">
        <a href="{{ route('admin.classes.create') }}" class="btn btn-primary">Create Class Schedule</a>
    </div>

    @if ($classes->isEmpty())
        <div class="alert alert-warning" role="alert">
            No class schedules found.
        </div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Sl</th>
                    <th>Class Time</th>
                    <th>Trainer Name</th>
                    <th>Class Name</th>
                    <th>Capacity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classes as $class)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($class->class_time)->format('Y-m-d H:i:s') }} to 
                            {{ \Carbon\Carbon::parse($class->class_time)->addHours(2)->format('H:i:s') }}
                        </td>
                        <td>{{ $class->trainer->user->name ?? 'N/A' }}</td>
                        <td>{{ $class->class_name }}</td>
                        <td>{{ $class->capacity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
