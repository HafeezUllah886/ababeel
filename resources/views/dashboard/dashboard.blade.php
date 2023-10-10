@php
    $page_title = "Dashboard";
    $page_dir = "Dashboard";
    $active = "dashboard";
    $menu = "open";
@endphp

@push('extra_css')
     <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
     <link href="{{ asset('assets/src/plugins/src/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
     <link href="{{ asset('assets/src/assets/css/dark/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" />
     <link href="{{ asset('assets/src/assets/css/light/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" />
     <link href="{{ asset('assets/src/assets/css/dark/components/list-group.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/src/assets/css/light/components/list-group.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/src/assets/css/dark/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/src/assets/css/light/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" />
     <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->
@endpush

@extends('layout.main')
@section('content')
    <!-- CONTENT AREA -->
<div class="row layout-top-spacing">

    <div class="col-12">
        <div class="row">
            @can('View Dashboard Monthly Expense')
                 <!-- Monthly Expenses -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-card-four">
                        <div class="widget-content">
                            <div class="w-header">
                                <div class="w-info">
                                    <h6 class="value">{{__('lang.MonthlyExpenses')}}</h6>
                                </div>
                            </div>
                            <div class="w-content">
                                <div class="w-info">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
            @can('View Dashboard Customer Dues')
                <!-- Customer Dues -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-card-four">
                        <div class="widget-content">
                            <div class="w-header">
                                <div class="w-info">
                                    <h6 class="value">{{__('lang.CustomerDues')}}</h6>
                                </div>
                            </div>
                            <div class="w-content">
                                <div class="w-info">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
            @can('View Dashboard Supplier Dues')
                 <!-- Supplier Dues -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-card-four">
                        <div class="widget-content">
                            <div class="w-header">
                                <div class="w-info">
                                    <h6 class="value">{{__('lang.SupplierDues')}}</h6>
                                </div>
                            </div>
                            <div class="w-content">
                                <div class="w-info">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
            @can('View Dashboard Monthly Sale')
                <!-- Monthly Sale -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-card-four">
                        <div class="widget-content">
                            <div class="w-header">
                                <div class="w-info">
                                    <h6 class="value">{{__('lang.MonthlySale')}}</h6>
                                </div>
                            </div>
                            <div class="w-content">
                                <div class="w-info">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
            @can('View Dashboard Total Sale')
                <!-- Total Cash -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-card-four">
                        <div class="widget-content">
                            <div class="w-header">
                                <div class="w-info">
                                    <h6 class="value">{{__('lang.TotalCash')}}</h6>
                                </div>
                            </div>
                            <div class="w-content">
                                <div class="w-info">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
            @can('View Dashboard Total Bank')
                 <!-- Total Bank -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-card-four">
                        <div class="widget-content">
                            <div class="w-header">
                                <div class="w-info">
                                    <h6 class="value">{{__('lang.TotalBank')}}</h6>
                                </div>
                            </div>
                            <div class="w-content">
                                <div class="w-info">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
             
        </div>
         
        <div class="row layout-top-spacing">
           
          
         
            
        </div>
    </div>

</div>
<!-- CONTENT AREA -->
@endsection

@push('extra_js')
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="{{ asset('assets/src/plugins/src/apex/apexcharts.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/src/assets/js/dashboard/dash_1.js') }}"></script> --}}
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
  
@endpush
