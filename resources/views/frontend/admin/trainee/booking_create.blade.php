@extends('layouts.layouts')

@section('content')
    <div class="container p-5">
        <h1 class="mb-4">Create Booking</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $booking = App\Models\ClassSchedule::all();
        @endphp

        <form action="{{ route('trainee.bookings.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="class_id" class="form-label">Select Class</label>
                <select id="class_id" name="class_id" class="form-select" required>
                    <option value="">-- Choose a Class --</option>
                    @foreach ($booking as $class)
                        <option value="{{ $class->id }}">
                            {{ $class->class_name }} - 
                            {{ $class->trainer->user->name ?? 'Unknown Trainer' }} - 
                            {{ \Carbon\Carbon::parse($class->class_time)->format('Y-m-d H:i') }} to 
                            {{ \Carbon\Carbon::parse($class->class_time)->addHours(2)->format('H:i') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Create Booking</button>
        </form>
    </div>
@endsection
