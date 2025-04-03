@extends('layout/main')
@section('title', 'dashboard')
@section('page-style')

@endsection

@section('content')
<div class="section-body mt-3">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="mb-4">
                    <h4>Welcome Dashboard!</h4>
                </div>                        
            </div>
        </div>
        <div class="row clearfix row-deck">
            <div class="col-xl-2 col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">User</h3>
                    </div>
                    <div class="card-body">
                        <h5 class="number mb-0 font-32 counter">{{$user?$user->count():'0'}}</h5>
                        <span class="font-12"><a href="#">More</a></span>
                    </div>
                </div>
            </div>
         
            
        </div>
    </div>
</div>
@endsection

@section('page-script')

@endsection