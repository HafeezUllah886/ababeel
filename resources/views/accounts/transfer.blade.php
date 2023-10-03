@php
    $page_title = "Transfer";
    $page_dir = "Transfer";
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
    <link href="{{asset('assets/src/plugins/src/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />
@endpush
@push('extra_js')
@endpush
@extends('layout.main')
@section('content')
    <!-- CONTENT AREA -->
<div class="row layout-top-spacing">

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex justify-content-between">
                    <h5>Transfer Amount</h5>
                </div>
                <form method="post" class="mt-3" >
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                    <label for="from">From</label>
                                    <select id="from" name="from">
                                        <option value=""></option>
                                         @foreach ($accounts as $account)
                                             <option {{ $account->id == old('account') ? 'selected' : '' }} value="{{ $account->id }}">{{ $account->type }} | {{ $account->title }}</option>
                                         @endforeach
                                      </select>
                                      @error('from')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                    <label for="to">To</label>
                                    <select id="to" name="to">
                                        <option value=""></option>
                                         @foreach ($accounts1 as $account1)
                                             <option {{ $account1->id == old('account') ? 'selected' : '' }} value="{{ $account1->id }}">{{ $account1->type }} | {{ $account1->title }}</option>
                                         @endforeach
                                      </select>
                                      @error('to')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                <label for="date">Date</label>
                                <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="form-control" id="date">
                                @error('date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                <label for="amount">Amount</label>
                                <input type="number" name="amount" step="0.1" Placeholder="Enter Amount" class="form-control">
                                @error('amount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group mt-3">
                                <label for="paidFrom">Description</label>
                                <textarea name="desc" class="form-control" rows="2"></textarea>
                                @error('desc')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                   <div class="row mt-3">
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Transfer Amount</button>
                    </div>
                   </div>
                </form>
                <hr>
                <h5>Transfer History</h5>
                <form id="form1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label for="from1">From</label>
                                <input type="date" class="form-control" onchange="get_items()" name="from1" id="from1">
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label for="to1">To</label>
                                <input type="date" class="form-control" onchange="get_items()" name="to1" id="to1">
                            </div>
                        </div>
                    </div>
                </form>
                <div id="items"></div>
            </div>
        </div>

    </div>

</div>
<!-- CONTENT AREA -->
@endsection


@push('extra_js')
        <script src="{{asset('assets/src/plugins/src/flatpickr/flatpickr.js')}}"></script>
        <script src="{{asset('assets/src/plugins/src/bootstrap-select/bootstrap-select.min.js')}}"></script>
    <script>
           $(document).ready(function(){
       var selectized = $('#from').selectize();
       var selectized = $('#to').selectize();
       /* selectized[0].selectize.focus(); */
       get_items();
    });


        $('#form1').submit(function (e) {
            e.preventDefault();
            return false;
        });

        function get_items(){
    var from = $('#from1').val();
    var to = $('#to1').val();
    $.ajax({
    method: "get",
    url: "{{url('/transfer/details/')}}/"+from+"/"+to,
    success: function(result){

        $("#items").html(result);
    }
    });
    }

    function printPage(id){
        var printWindow = window.open("{{url('/inflow/pdf/')}}/"+id, '_blank');
        printWindow.onload = function() {
        printWindow.print();
        setTimeout(function() {
        printWindow.close();
        }, 2000); // Delay in milliseconds (1 second)

    };
    }

    var date = new Date();
        var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);

        var f2 = flatpickr(document.getElementById('from1'), {
    dateFormat: "d-m-Y",
    defaultDate: firstDay
    });

    var f2 = flatpickr(document.getElementById('to1'), {
    dateFormat: "d-m-Y",
    defaultDate: lastDay
    });
    </script>
@endpush
