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

                                    <!-- Working Hours -->
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

                                    <!-- Hidden Input for Schedule -->
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

    document.querySelectorAll('.add-time-slot').forEach(button => {
        button.addEventListener('click', function () {
            let day = this.getAttribute('data-day');
            let container = document.getElementById('slots-' + day);

            let slotDiv = document.createElement('div');
            slotDiv.classList.add('time-slot-entry');
            slotDiv.innerHTML = `
                <input type="time" class="start-time" required> to 
                <input type="time" class="end-time" required>
                <button type="button" class="btn btn-sm btn-danger remove-slot">X</button>
            `;

            container.appendChild(slotDiv);
            updateSchedule();
        });
    });

    // Event delegation for removing slots
    document.body.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-slot')) {
            event.target.parentNode.remove();
            updateSchedule();
        }
    });

    function updateSchedule() {
        schedule = {};
        document.querySelectorAll('.time-slots').forEach(container => {
            let day = container.id.replace('slots-', '');
            let slots = [];

            container.querySelectorAll('.time-slot-entry').forEach(slot => {
                let startTime = slot.querySelector('.start-time').value;
                let endTime = slot.querySelector('.end-time').value;
                if (startTime && endTime) {
                    slots.push({ start: startTime, end: endTime });
                }
            });

            if (slots.length) {
                schedule[day] = slots;
            }
        });

        document.getElementById('schedule_input').value = JSON.stringify(schedule);
    }

    // Ensure schedule is updated before form submission
    document.querySelector('form').addEventListener('submit', function () {
        updateSchedule();
    });
});
</script>
@endsection
