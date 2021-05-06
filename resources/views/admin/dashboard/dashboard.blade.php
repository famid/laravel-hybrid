@extends('admin.layouts.master')
@section('title', __('Dashboard'))
@section('style')
    <style>
        .dashboard-content {
            max-width: 100% !important;
        }
    </style>
@endsection

@section('content')

        <div class="breadcrumb">
            <h1 class="mr-2">Version 1</h1>
            <ul>
                <li><a href="">Dashboard</a></li>
                <li>Version 1</li>
            </ul>
        </div>

        <div class="separator-breadcrumb border-top"></div>

        <div class="row">
            <!-- ICON BG -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Add-User"></i>
                        <div class="content">
                            <p class="text-muted mt-2 mb-0">New Leads</p>
                            <p class="text-primary text-24 line-height-1 mb-2">205</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Financial"></i>
                        <div class="content">
                            <p class="text-muted mt-2 mb-0">Sales</p>
                            <p class="text-primary text-24 line-height-1 mb-2">$4021</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Checkout-Basket"></i>
                        <div class="content">
                            <p class="text-muted mt-2 mb-0">Orders</p>
                            <p class="text-primary text-24 line-height-1 mb-2">80</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                    <div class="card-body text-center">
                        <i class="i-Money-2"></i>
                        <div class="content">
                            <p class="text-muted mt-2 mb-0">Expense</p>
                            <p class="text-primary text-24 line-height-1 mb-2">$1200</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>


@endsection

@section('script')
@endsection
