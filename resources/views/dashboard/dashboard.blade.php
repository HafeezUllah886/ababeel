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
                                    <p class="value">Rs. {{ round(monthlyExpense(), 0) }} <span>{{__('lang.ThisMonth')}}</span> </p>
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
                                    <p class="value text-success">Rs. {{ round(customerDues(), 0) }}</p>
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
                                    <p class="value text-warning">Rs. {{ round(supplierDues(), 0) }}</p>
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
                                    <p class="value text-success">Rs. {{ round(monthlySale(), 0) }} <span>{{__('lang.ThisMonth')}}</span> </p>
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
                                    <p class="value text-info">Rs. {{ round(totalCash(), 0) }} </p>
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
                                    <p class="value text-primary">Rs. {{ round(totalBank(), 0) }} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
             
        </div>
         
        <div class="row layout-top-spacing">
            @php
           $i_e = i_e(); // Call the function and assign the returned array to $i_e variable

            $expenseData = [];
            $incomeData = [];
            $labels = [];

            foreach ($i_e as $item) {
                $expenseData[] = round($item['total_expense'],0);
                $incomeData[] = round($item['total_income'],0);
                $labels[] = date("M", strtotime($item['year'] ."-" .$item['month']."-1"));
            }

            @endphp
            @can('View Dashboard Income & Expense')
                <!-- Income & Expenses -->
                <div class="col-12 layout-spacing">
                    <div class="widget widget-chart-one">
                        <div class="widget-heading">
                            <h5 class="">Income & Expense (last 12 months)</h5>

                        </div>

                        <div class="widget-content">
                            <div id="revenueMonthly"></div>
                        </div>
                    </div>
                </div>
            @endcan
            @can('View Dashboard Top Selling')
                <!-- Top Selling Products -->
                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-table-three">

                        <div class="widget-heading">
                            <h5 class="">Top Selling Products</h5>
                        </div>

                        <div class="widget-content">
                            <div class="table-responsive">
                                <table class="table table-scroll">
                                    <thead>
                                        <tr>
                                            <th><div class="th-content">Product</div></th>
                                            <th><div class="th-content th-heading">Color</div></th>
                                            <th><div class="th-content th-heading">Size</div></th>
                                            <th><div class="th-content">Sold</div></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topSellingProducts as $pro)
                                        @if (!$pro->total_sold)
                                        @else
                                        <tr>
                                            <td><div class="td-content product-name"><img src="{{$pro->product->img}}" alt="product"><div class="align-self-center"><p class="prd-name">{{$pro->product->title}}</p><p class="prd-category text-primary">{{$pro->product->code}}</p></div></div></td>
                                            <td><div class="td-content"><span class="pricing">{{$pro->product->color}}</span></div></td>
                                            <td ><div class="td-content" style="margin:0;">{{round($pro->product->width,2)}}x{{round($pro->product->length,2)}}</div></td>
                                            <td><div class="td-content">{{round($pro->total_sold,1)}}</div></td>
                                        </tr>
                                        @endif
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
            @can('View Dashboard Transactions')
                <!-- Transactions -->
                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-table-one">
                        <div class="widget-heading">
                            <h5 class="">Transactions</h5>
                        </div>

                        <div class="widget-content">
                            @php
                                $acct_color = null;
                                $tran_color = null;
                                $amount = 0;
                                $sign = null;
                            @endphp
                            @foreach ($transactions as $trans)
                            @php
                                if($trans->cr > 0)
                                {
                                    $tran_color = "rate-inc";
                                    $amount = $trans->cr;
                                    $sign = "+Rs. ";
                                }
                                if($trans->db > 0) {
                                    $tran_color = "rate-dec";
                                    $amount = $trans->db;
                                    $sign = "-Rs. ";
                                }
                                if($trans->db > 0 && $trans->cr > 0){
                                    $tran_color = "rate-inc";
                                    $amount = $trans->cr - $trans->db;
                                    $sign = "+Rs. ";
                                }
                                if($trans->account->type == "Business")
                                {
                                    $acct_color = "t-info";
                                }
                                if($trans->account->type == "Customer")
                                {
                                    $acct_color = "t-danger";
                                }
                                if($trans->account->type == "Supplier")
                                {
                                    $acct_color = "t-warning";
                                }

                            @endphp
                            @if ($amount > 0)
                            <div class="transactions-list {{$acct_color}}">
                                <div class="t-item">
                                    <div class="t-company-name">
                                        <div class="t-icon">
                                            <div class="avatar">
                                                <span class="avatar-title text-uppercase">{{getInitials($trans->account->title)}}</span>
                                            </div>
                                        </div>
                                        <div class="t-name">
                                            <h4>{{$trans->account->title}}</h4>
                                            <p class="meta-date">{{date('d M Y', strtotime($trans->date))}}</p>
                                        </div>
                                    </div>
                                    <div class="t-rate {{$tran_color}}">
                                        <p><span>{{$sign}}{{round($amount,0)}}</span></p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @php
                                $amount = 0;
                            @endphp
                            @endforeach

                        </div>
                    </div>
                </div>
            @endcan
            
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
    @include('dashboard.dashjs')
@endpush
