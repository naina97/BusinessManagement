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
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped text-nowrap table-vcenter mb-0">
                                        <thead>
                                            <tr>
                                                <th>Business Name</th>
                                                <th>Branch Name</th>
                                                <th>Branch Detailes</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($branches as $branch)
                                                <tr>
                                                    <td>{{ $branch->business?$branch->business->name :''}}</td>
                                                    <td>{{ $branch->name }}</td>
                                                    <td>
                                                            <a href="{{ route('branches.show', $branch->id) }}">{{ $branch->name }}</a><br>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('branches.destroy', $branch->id) }}" method="POST">
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