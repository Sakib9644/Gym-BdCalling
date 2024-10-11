@extends('layouts.layouts')

@section('content')
    <div class="container p-5">
        <h1 class="mb-4">My Bookings</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('trainee.bookings.create') }}" class="btn btn-primary mb-4">Create Booking</a> <!-- Create Booking Button -->

        @if ($bookings->isEmpty())
            <div class="alert alert-info">You have no bookings yet.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Class Name</th>
                            <th>Class Time</th>
                            <th>Booking Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td>{{ $booking->classSchedule->name ?? 'N/A' }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($booking->classSchedule->class_time)->format('Y-m-d H:i') }} 
                                    to 
                                    {{ \Carbon\Carbon::parse($booking->classSchedule->class_time)->addHours(2)->format('H:i') }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($booking->created_at)->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
