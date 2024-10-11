@extends('layouts.layouts')

@section('content')
    <div class="container p-5">
        <h1 class="mb-4">Trainers</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Expertise</th>
                        <th>Availability</th>
                        <th>Class Times and Assigned Trainees</th> <!-- Merged column header -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trainers as $trainer)
                        <tr>
                            <td>{{ $trainer->user->name ?? 'N/A' }}</td>
                            <td>{{ $trainer->user->email ?? 'N/A' }}</td>
                            <td>{{ $trainer->expertise }}</td>
                            <td>
                                @php
                                    $availabilityArray = json_decode($trainer->availability, true);
                                @endphp
                                {{ !empty($availabilityArray) ? implode(', ', $availabilityArray) : 'N/A' }}
                            </td>
                            <td>
                                @if ($trainer->classes->isEmpty())
                                    N/A
                                @else
                                    <ul class="list-unstyled">
                                        @foreach ($trainer->classes as $class)
                                            @php
                                                $assignedTrainees = App\Models\Booking::where('class_id', $class->id)->get();
                                            @endphp
                                                @if ($assignedTrainees->isNotEmpty())
                                                    <ul class="list-unstyled">
                                                        @foreach ($assignedTrainees as $booking)
                                                            <li>{{ $booking->user->name ?? 'No name' }}</li>
                                                        @endforeach
                                                    </ul>
                                             
                                                @endif
                                            <li>
                                                Class: {{ \Carbon\Carbon::parse($class->class_time)->format('Y-m-d H:i') }} to 
                                                {{ \Carbon\Carbon::parse($class->class_time)->addHours(2)->format('H:i') }}<br>

                                                <strong>Trainees: {{ $assignedTrainees->count() }}</strong><br>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
