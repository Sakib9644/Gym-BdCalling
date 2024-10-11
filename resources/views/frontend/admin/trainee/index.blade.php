@extends('layouts.layouts')

@section('content')
    <div class="container p-5">
        <h1 class="mb-4">Trainee Profile</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Profile Information</h5>
                <form method="POST" action="{{ route('trainee.profile.update') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $trainee->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $trainee->email) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password (leave blank to keep current password):</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
@endsection
