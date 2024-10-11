@extends('layouts.layouts')

@section('content')
<div class="container p-5">
    <h1 class="mb-4">Add Trainer</h1>
    <form action="{{ route('admin.trainers.store') }}" method="POST" id="trainerForm">
        @csrf
        <div class="form-group mb-3">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="expertise">Expertise</label>
            <input type="text" name="expertise" class="form-control" required>
        </div>

        <label for="availability">Availability</label>
        <div class="form-group" id="availabilityContainer">
            <div class="availability-item mb-2">
                <input type="text" name="availability[]" class="form-control datepicker" placeholder="Select availability date" required>
            </div>
            <button type="button text-end" class="btn btn-secondary mb-3" id="addAvailability">Add Availability</button>
        </div>


        <button type="submit" class="btn btn-primary mt-3 float-right">Add Trainer</button>
    </form>
</div>


@endsection
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
            const newAvailability = $('<div class="availability-item mb-2">' +
                '<input type="text" name="availability[]" class="form-control datepicker" placeholder="Select availability date" required>' +
                '<button type="button" class="btn btn-danger btn-sm removeAvailability">Remove</button>' +
                '</div>');
            
            $('#availabilityContainer').append(newAvailability);
            newAvailability.find('.datepicker').datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: 0
            });
        });

        $('#availabilityContainer').on('click', '.removeAvailability', function() {
            $(this).closest('.availability-item').remove();
        });
    });
</script>