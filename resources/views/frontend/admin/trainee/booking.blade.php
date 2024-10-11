@extends('layouts.layouts')

@section('content')
    <div class="container p-5">
        <h1 class="mb-4">My Bookings</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('trainee.bookings.create') }}" class="btn btn-primary mb-4">Create Booking</a>

        @if ($bookings->isEmpty())
            <div class="alert alert-info">You have no bookings yet.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Class Name</th>
                            <th>Trainer Name</th>
                            <th>Class Time</th>
                            <th>Actions</th> <!-- New Actions Column -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td>{{ $booking->class->class_name ?? 'N/A' }}</td>
                                <td>{{ $booking->class->trainer->user->name ?? 'Unknown Trainer' }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($booking->class->class_time)->format('Y-m-d H:i') }} 
                                    to 
                                    {{ \Carbon\Carbon::parse($booking->class->class_time)->addHours(2)->format('H:i') }}
                                </td>
                                <td>
                                    <form action="{{ route('trainee.bookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
