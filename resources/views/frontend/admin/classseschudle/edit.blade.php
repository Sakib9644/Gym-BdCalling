@extends('layouts.layouts')

@section('content')
<div class="container p-5">
    <h1>Edit Class Schedule</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{ route('admin.classes.update', $class->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="class_time" class="form-label">Class Time</label>
            <input type="text" class="form-control @error('class_time') is-invalid @enderror" id="class_time" name="class_time" required>
        </div>
        @php
        $trainers = App\Models\Trainer::all();
    @endphp
        <div class="mb-3">
            <label for="trainer_id" class="form-label">Trainer</label>
            <select name="trainer_id" id="trainer_id" class="form-select" required>
                <option value="">Select Trainer</option>
                @foreach($trainers as $trainer)
                    <option value="{{ $trainer->id }}" {{ $class->trainer_id == $trainer->id ? 'selected' : '' }}>
                        {{ $trainer->user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="class_name" class="form-label">Class Name</label>
            <input type="text" name="class_name" id="class_name" class="form-control" value="{{ $class->class_name }}" required>
        </div>

        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" name="capacity" id="capacity" class="form-control" value="{{ $class->capacity }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update Class Schedule</button>
        <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#class_time').datetimepicker({
                format: 'Y-m-d H:i', 
                step: 30, 
            });
        });
    </script>
