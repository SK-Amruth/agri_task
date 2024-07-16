@extends('layouts.app')

@section('title', 'Home')

@section('styles')
@endsection

@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
            
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-center border-0 mb-5 mb-xl-10" style="background-color: #080655">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">   
                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{$users}}</span>
                                <span class="text-white opacity-50 pt-1 fw-semibold fs-2">Active Users</span>             
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="col-lg-6">
            
                    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-center border-0 mb-5 mb-xl-10" style="background-color: #080655">
                        <div class="card-header pt-5">
                            <div class="card-title d-flex flex-column">   
                                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{$totalAmount}}</span>
                                <span class="text-white opacity-50 pt-1 fw-semibold fs-2">Total Balance</span>             
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>
@endsection

@section('drawers')
@endsection

@section('modals')
@endsection

@section('scripts')
@endsection
