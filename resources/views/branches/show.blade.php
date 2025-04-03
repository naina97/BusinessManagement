@extends('layout/main')
@section('title', 'Branch')

@section('page-style')
  <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" />
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
                    <li class="breadcrumb-item active" aria-current="page">Branch List</li>
                </ol>
            </nav>

            <div class="d-flex gap-2">
                <a href="{{ route('branches.create') }}">
                    <button type="button" class="btn btn-danger">Add New Branches</button>
                </a>
            </div>
        </div>
        @include('layout/toaster')
            <div class="row clearfix">
               <div class="col-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                                   <a href="{{ route('businesses.index') }}" class="btn btn-secondary mb-3">Back</a>

                                    <h3>Branch: {{ $branch->name }}</h3>
                                    <p>Business: {{ $branch->business->name }}</p>

                                    <h4>Operating Hours:</h4>
                                    <ul>
                                        @foreach ($branch->schedule as $day => $times)
                                            <li><strong>{{ $day }}:</strong>
                                                @if(empty($times))
                                                    Closed
                                                @else
                                                    @foreach ($times as $time)
                                                        {{ $time['start'] }} - {{ $time['end'] }}
                                                    @endforeach
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                    <h4>Current Status:</h4>
                                    <span class="badge {{ $isOpen ? 'bg-success' : 'bg-danger' }}">
                                        {{ $isOpen ? 'Open' : 'Closed' }}
                                    </span>


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
$(document).ready(function() {
    setInterval(function() {
        location.reload();
    }, 10000); // Refresh every minute
});
</script>
@endsection
