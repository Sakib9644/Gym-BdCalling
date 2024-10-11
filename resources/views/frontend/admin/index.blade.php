@extends('layouts.layouts')

@section('content')
    <div class="container p-5">
        <h1>Trainers</h1>
        <a href="{{ route('admin.trainers.create') }}" class="btn btn-primary">Add Trainer</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Expertise</th>
                    <th>Availability</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trainers as $trainer)
                    <tr>
                        <td>{{ $trainer->user->name ?? null }}</td>
                        <td>{{ $trainer->user->email ?? null }}</td>
                        <td>{{ $trainer->expertise }}</td>
                        <td>
                            @php
                                $availabilityArray = json_decode($trainer->availability, true);
                            @endphp
                            {{ !empty($availabilityArray) ? implode(', ', $availabilityArray) : 'N/A' }}
                        </td>
                        <td>
                            {{-- <a href="{{ route('admin.trainers.show', $trainer->id) }}" class="btn btn-info">View</a> --}}
                            <a href="{{ route('admin.trainers.edit', $trainer->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.trainers.destroy', $trainer->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
