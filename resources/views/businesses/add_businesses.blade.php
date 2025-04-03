@extends('layout/main')
@section('title', 'Add Business')

@section('page-style')
<style>
    .text-red{
        color:red;
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
                    {{-- <li class="breadcrumb-item active" aria-current="page"> <a href="#">Add Booking</a></li> --}}
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
                            <form action="{{ route('businesses.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Business Name <span class="text-danger">*</span></label>
                                            <input class="form-control" name="business_name" type="text" value="{{ old('business_name') }}"  required>
                                            @error('business_name')
                                                <div class="text-red">{{ $message }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input class="form-control" name="email" type="text" value="{{ old('email') }}" required>
                                            @error('email')
                                                <div class="text-red">{{ $message }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Phone <span class="text-danger">*</span></label>
                                            <input class="form-control" name="phone" type="text" value="{{ old('phone') }}" required>
                                            @error('phone')
                                                <div class="text-red">{{ $message }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Logo </label>
                                            <input class="form-control" name="logo" type="file" value="">
                                            @error('logo')
                                                <div class="text-red">{{ $message }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-right m-t-20">
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
    $(document).ready(function() 
    {
       
    });
</script>
@endsection