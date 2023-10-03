@php
    $page_title = "Purchase";
    $page_dir = "Purchase";
    $active = "inflow";
    $menu = "open";
@endphp

@push('extra_css')
<link href="{{asset('assets/src/plugins/src/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />
@endpush
@push('extra_js')
    <script src="{{ asset('assets/src/plugins/src/jquery-ui/jquery.min.js') }}"></script>
    <script src="{{asset('assets/src/plugins/src/bootstrap-select/bootstrap-select.min.js')}}"></script>
    <script>
           $(document).ready(function(){
       var selectized = $('#normalize').selectize();
       /* selectized[0].selectize.focus(); */
    });
    </script>
@endpush
@extends('layout.main')
@section('content')
    <!-- CONTENT AREA -->
<div class="row layout-top-spacing">

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex justify-content-between">
                    <h5>Create Receiving Vouchare</h5>
                </div>
                <form method="post" class="mt-3" >
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                    <label for="normalize">Supplier</label>
                                    <select id="normalize" name="supplier">
                                        <option value=""></option>
                                         @foreach ($suppliers as $supplier)
                                             <option {{ $supplier->id == old('supplier') ? 'selected' : '' }} value="{{ $supplier->id }}">{{ $supplier->title }}</option>
                                         @endforeach
                                      </select>
                                      @error('supplier')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="date">Date</label>
                                <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" class="form-control" id="date">
                                @error('date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="isPaid">Is Paid</label>
                               <Select name="isPaid" class="form-control">
                                <option {{ old('isPaid') == 'yes' ? 'selected' : '' }} value="yes">Yes</option>
                                <option {{ old('isPaid') == 'no' ? 'selected' : '' }} value="no">No</option>
                               </Select>
                                @error('isPaid')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="paidFrom">Paid From</label>
                               <Select name="paidFrom" class="form-control">
                                <option value="">Select</option>
                                    @foreach ($accounts as $account)
                                        <option {{ $account->id == old('paidFrom') ? 'selected' : '' }} value="{{ $account->id }}">{{ $account->title }}</option>
                                    @endforeach
                               </Select>
                                @error('paidFrom')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                   <div class="row mt-3">
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Next <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></button>
                    </div>
                   </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- CONTENT AREA -->
@endsection

