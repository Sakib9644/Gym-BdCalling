@extends('layouts.layouts')

@section('content')
<div class="container p-5">
    <h1 class="mb-4">Update Trainer</h1>
    <form action="{{ route('admin.trainers.update', $trainer->id) }}" method="POST" id="trainerForm">
        @csrf
        @method('PUT') <!-- Include method spoofing for PUT request -->
        
        <div class="form-group mb-3">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $trainer->user->name) }}" >
        </div>
        
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $trainer->user->email) }}" >
        </div>
        
        <div class="form-group mb-3">
            <label for="password">Password (leave blank to keep current password)</label>
            <input type="password" name="password" class="form-control">
        </div>
        
        <div class="form-group mb-3">
            <label for="expertise">Expertise</label>
            <input type="text" name="expertise" class="form-control" value="{{ old('expertise', $trainer->expertise) }}" >
        </div>

        <label for="availability">Availability</label>
        <div class="form-group d-flex flex-column" id="availabilityContainer">
            @php
                $availabilityArray = json_decode($trainer->availability, true);
            @endphp
            
            @foreach ($availabilityArray as $availability)
                <div class="availability-item mb-2 d-flex align-items-center">
                    <input type="text" name="availability[]" class="form-control datepicker me-2" placeholder="Select availability date" value="{{ $availability }}" >
                    <button type="button" class="btn btn-danger removeAvailability">Remove</button>
                </div>
            @endforeach
            
            <div class="availability-item mb-2 d-flex ">
                <input type="text" name="availability[]" class="form-control datepicker me-2" placeholder="Select availability date" >
                <button type="button" class="btn btn-secondary " id="addAvailability">Add </button>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Trainer</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
    $(document).ready(function() {
        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 0 
        });

        $('#addAvailability').on('click', function() {
            const newAvailability = $('<div class="availability-item mb-2 d-flex align-items-center">' +
                '<input type="text" name="availability[]" class="form-control datepicker me-2" placeholder="Select availability date" required>' +
                '<button type="button" class="btn btn-danger removeAvailability">Remove</button>' +
                '</div>');
            
            $('#availabilityContainer').append(newAvailability);
            newAvailability.find('.datepicker').datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: 0
            });
        });

        $(document).on('click', '.removeAvailability', function() {
            $(this).closest('.availability-item').remove();
        });
    });
</script>
@endsection
