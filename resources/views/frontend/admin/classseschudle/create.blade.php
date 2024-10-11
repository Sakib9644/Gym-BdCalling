@extends('layouts.layouts')

@section('content')
<div class="container p-5">
    <h1>Create Class Schedule</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('admin.classes.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="class_time" class="form-label">Class Time</label>
            <input type="text" class="form-control @error('class_time') is-invalid @enderror" id="class_time" name="class_time" required>
            @error('class_time')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        @php
            $trainers = App\Models\Trainer::all();
        @endphp

        <div class="mb-3">
            <label for="trainer_id" class="form-label">Trainer</label>
            <select class="form-select @error('trainer_id') is-invalid @enderror" id="trainer_id" name="trainer_id" required>
                <option value="" disabled selected>Select Trainer</option>
                @foreach ($trainers as $trainer)
                    <option value="{{ $trainer->id }}">{{ $trainer->user->name }}</option>
                @endforeach
            </select>
            @error('trainer_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="class_name" class="form-label">Class Name</label>
            <input type="text" class="form-control @error('class_name') is-invalid @enderror" id="class_name" name="class_name" required>
            @error('class_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" class="form-control @error('capacity') is-invalid @enderror" id="capacity" name="capacity" required min="1">
            @error('capacity')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Create Class Schedule</button>
    </form>
</div>


@endsection

@push('scripts')
   
    <script>
        $(document).ready(function() {
            $('#class_time').datetimepicker({
                format: 'Y-m-d H:i', 
                step: 30, 
            });
        });
    </script>
@endpush