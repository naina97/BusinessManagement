@extends('layout/main')
@section('title', 'Business')

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
                    <li class="breadcrumb-item active" aria-current="page">Business List</li>
                </ol>
            </nav>

            <div class="d-flex gap-2">
                <a href="{{ route('businesses.create') }}">
                    <button type="button" class="btn btn-danger">Add New Business</button>
                </a>
            </div>
        </div>
        @include('layout/toaster')
            <div class="row clearfix">
               <div class="col-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped text-nowrap table-vcenter mb-0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Loo</th>
                                                {{-- <th>Branches</th> --}}
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($businesses as $business)
                                                <tr>
                                                    <td>{{ $business->name }}</td>
                                                    <td>{{ $business->email }}</td>
                                                    <td>{{ $business->phone }}</td>
                                                    <td><img src="{{ asset('storage/app/public/'.$business->logo) }}" width="50"></td>

                                                    {{-- <td>
                                                        @foreach ($business->branches as $branch)
                                                            <a href="{{ route('branches.show', $branch) }}">{{ $branch->name }}</a><br>
                                                        @endforeach
                                                    </td> --}}
                                                    <td>
                                                        <form action="{{ route('businesses.destroy', $business) }}" method="POST">
                                                            @csrf @method('DELETE')
                                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection

@section('page-script')

@endsection