@extends('layout/main')
@section('title', 'Add Branch')

@section('page-style')
<style>
    .text-red {
        color: red;
    }
</style>
@endsection

@section('content')
<div class="section-body mt-3">
    <div class="container-fluid">
        <!-- Breadcrumb and Button Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                </ol>
            </nav>
        </div>

        <div class="row clearfix">
            @if ($errors->any()) 
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
            @endif 

            <div class="col-12 col-sm-12">
                <div class="tab-content">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add Business</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('branches.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- Select Business -->
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Select Business</label>
                                            <select class="form-control" name="business_id" id="business_id">
                                                <option value="">Select Parent Category</option>
                                                @foreach ($businesses as $business)
                                                    <option value="{{ $business->id }}">{{ $business->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Branch Name -->
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Branch Name <span class="text-danger">*</span></label>
                                            <input class="form-control" name="branch_name" type="text" value="{{ old('branch_name') }}" required>
                                            @error('branch_name')
                                                <div class="text-red">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Images Upload -->
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Images</label>
                                            <input class="form-control" name="images[]" type="file" multiple>
                                        </div>
                                    </div>

                                   <div class="col-md-12">
                                        <div class="form-group">
                                            <h4>Working Hours:</h4>
                                            <div id="working-hours-container">
                                                @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                                                    <div class="form-group">
                                                        <label>{{ $day }}</label>
                                                        <button type="button" class="btn btn-sm btn-success add-time-slot" data-day="{{ $day }}">Add Time Slot</button>
                                                        <div class="time-slots" id="slots-{{ $day }}"></div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Hidden Input to Store JSON Schedule -->
                                    <input type="hidden" name="schedule" id="schedule_input">
                                </div>

                                <!-- Submit Button -->
                                <div class="row">
                                    <div class="col-sm-12 text-right mt-3">
                                        <button type="submit" class="btn btn-primary">SAVE</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script>
document.addEventListener("DOMContentLoaded", function () {
    let schedule = {}; 

    console.log("Script is running!"); // Debugging step 1

    // Function to add a new time slot for a specific day
    document.querySelectorAll('.add-time-slot').forEach(button => {
        button.addEventListener('click', function () {
            let day = this.getAttribute('data-day');
            let container = document.getElementById('slots-' + day);

            console.log(`Adding time slot for ${day}`); // Debugging step 2

            // Create a unique ID for new input fields
            let uniqueID = Date.now();

            // Create new slot inputs
            let slotDiv = document.createElement('div');
            slotDiv.classList.add('time-slot-entry', 'mt-2');
            slotDiv.setAttribute('data-slot-id', uniqueID);
            slotDiv.innerHTML = `
                <input type="time" class="start-time" name="start-time-${uniqueID}" required> to 
                <input type="time" class="end-time" name="end-time-${uniqueID}" required>
                <button type="button" class="btn btn-sm btn-danger remove-slot">X</button>
            `;

            container.appendChild(slotDiv);
            updateSchedule(); // Ensure data updates
        });
    });

    // Remove a time slot when clicking "X"
    document.body.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-slot')) {
            let parentDiv = event.target.closest('.time-slot-entry');
            parentDiv.remove();
            updateSchedule(); // Ensure data updates
        }
    });

    // Function to update schedule data before form submission
    function updateSchedule() {
        schedule = {}; // Reset the schedule object
        console.log("Updating schedule..."); // Debugging step 3

        document.querySelectorAll('.time-slots').forEach(container => {
            let day = container.id.replace('slots-', '');
            let slots = [];

            container.querySelectorAll('.time-slot-entry').forEach(slot => {
                let startTimeInput = slot.querySelector('.start-time');
                let endTimeInput = slot.querySelector('.end-time');

                let startTime = startTimeInput.value;
                let endTime = endTimeInput.value;

                console.log(`Slot detected for ${day}: ${startTime} - ${endTime}`); // Debugging step 4

                if (startTime && endTime && startTime < endTime) {
                    slots.push({ start: startTime, end: endTime });
                }
            });

            if (slots.length > 0) {
                schedule[day] = slots;
            }
        });

        let scheduleJSON = JSON.stringify(schedule);
        console.log("Final schedule JSON:", scheduleJSON); // Debugging step 5
        document.getElementById('schedule_input').value = scheduleJSON;
    }

    // Ensure schedule updates before form submission
    document.querySelector('form').addEventListener('submit', function () {
        updateSchedule();
        console.log("Submitting Schedule:", document.getElementById('schedule_input').value);
    });

    // Bind change event for dynamically added inputs
    document.body.addEventListener('change', function (event) {
        if (event.target.classList.contains('start-time') || event.target.classList.contains('end-time')) {
            updateSchedule();
        }
    });
});



</script>
@endsection
