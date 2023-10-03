@php
    $page_title = "Statement";
    $page_dir = "Statement";
    $active = "finance";
    $menu = "open";
@endphp

@push('extra_css')
    <link rel="stylesheet" href="{{asset('assets/src/plugins/src/flatpickr/flatpickr.css')}}">
    <link rel="stylesheet" href="{{asset('assets/src/plugins/css/dark/flatpickr/custom-flatpickr.css')}}">
    <link rel="stylesheet" href="{{asset('assets/src/plugins/css/light/flatpickr/custom-flatpickr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/src/plugins/src/glightbox/glightbox.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/src/plugins/src/table/datatable/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/src/plugins/css/light/table/datatable/dt-global_style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/src/plugins/css/dark/table/datatable/dt-global_style.css')}}">
@endpush

@extends('layout.main')
@section('content')
    <!-- CONTENT AREA -->
<div class="row layout-top-spacing">

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex justify-content-between">
                    <h5>Account Statement</h5>
                    <div>
                        <button onclick="printPage({{ $id }})" class="btn btn-info">Print</button>
                    </div>

                </div>
                    <div class="row">
                        <div class="col-md-6">
                           <div class="row">
                            <table class="table w-90">
                                    <tr>
                                        <td>Account:</td>
                                        <td>{{ $account->title }}</td>
                                    </tr>
                                    <tr>
                                        <td>Type:</td>
                                        <td>{{ $account->type }}</td>
                                    </tr>
                                   @if($account->type != 'Business')
                                   <tr>
                                    <td>Contact:</td>
                                    <td>{{ $account->contact }}</td>
                                </tr>
                                <tr>
                                    <td>Address:</td>
                                    <td>{{ $account->address }}</td>
                                </tr>
                                   @endif

                                </table>

                           </div>
                        </div>
                        <div class="col-md-6">
                            <form id="form">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mt-2">
                                            <label for="from">From</label>
                                            <input type="date" class="form-control" onchange="get_items()" name="from" id="from">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label for="to">To</label>
                                            <input type="date" class="form-control" onchange="get_items()" name="to" id="to">
                                        </div>
                                    </div>
                                </div>
                            </form>



                        </div>
                    </div>
                <div id="items" class="table-responsive"></div>
            </div>
        </div>
    </div>


</div>
<!-- CONTENT AREA -->
@endsection

@push('extra_js')

        <script src="{{asset('assets/src/plugins/src/flatpickr/flatpickr.js')}}"></script>


    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ asset('/assets/src/plugins/src/glightbox/glightbox.min.js')}}"></script>
    <script src="{{ asset('/assets/src/plugins/src/glightbox/custom-glightbox.min.js')}}"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
        <script>


        $('#form').submit(function (e) {
            e.preventDefault();
            return false;
        });
        $(document).ready(function(){

    get_items();
    });

    function get_items(){
    var from = $('#from').val();
    var to = $('#to').val();
    $.ajax({
    method: "get",
    url: "{{url('/account/details/')}}/"+{{$id}}+"/"+from+"/"+to,
    success: function(result){

        $("#items").html(result);
    }
    });
    }

    function printPage(id){
        var from = $("#from").val();
        var to = $("#to").val();
        var printWindow = window.open("{{url('/statement/pdf/')}}/"+id+"/"+from+"/"+to, '_blank');
        printWindow.onload = function() {
        printWindow.print();
        setTimeout(function() {
        printWindow.close();
        }, 2000);

    };
    }

    var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);

        var f2 = flatpickr(document.getElementById('from'), {
    dateFormat: "d-m-Y",
    defaultDate: firstDay
    });

    var f2 = flatpickr(document.getElementById('to'), {
    dateFormat: "d-m-Y",
    defaultDate: lastDay
    });
    </script>
@endpush
