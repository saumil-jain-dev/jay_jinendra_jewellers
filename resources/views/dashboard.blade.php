@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Dashboard Header -->
            <div class="col-md-12">
                <h1 class="my-4">Dashboard</h1>
            </div>
        </div>

        <div class="row">
            <!-- User Statistics Card -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow border-left-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Registered Users</h5>
                        <h2>{{ $userCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow border-left-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Guarantors</h5>
                        <h2>{{ $guarantorsCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow border-left-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Invoiced Amount (₹)</h5>
                        <h2>{{ number_format($billingTotal, 2, '.', ',') }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow border-left-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Cash Received (₹)</h5>
                        <h2>{{ number_format($cashReceptTotal, 2, '.', ',') }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow border-left-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Online Payments (₹)</h5>
                        <h2>{{ number_format($onlineReceptTotal, 2, '.', ',') }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card shadow border-left-primary">
                    <div class="card-body">
                        <h5 class="card-title">Outstanding Balance (₹)</h5>
                        <h2>{{ number_format($remainingTotal, 2, '.', ',') }}</h2>
                    </div>
                </div>
            </div>
        </div>


    </div>


@endsection