@php
    $page_title = "Edit Warehouse";
    $page_dir = "EditWarehouse";
    $active = "warehouse";
    $menu = "open";
@endphp
@extends('layout.main')
@section('content')
    <!-- CONTENT AREA -->
<div class="row layout-top-spacing">
    <div class="col-12 d-flex justify-content-end mb-3">
        <a href="{{url('/warehouse')}}" class="btn btn-dark">{{ __('lang.GoBack') }}</a>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title"><h5>Edit Warehouse</h5> </div>
                <form method="post" action="{{ url('/warehouse/update/') }}/{{ $warehouse->id }}" class="mt-3" >
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="title">Warehouse Name</label>
                                <input type="text" name="name" placeholder="Enter warehouse name" value="{{ $warehouse->name }}" class="form-control" id="">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="code">Location</label>
                                <input type="text" placeholder="Enter warehouse location" value="{{ $warehouse->location }}" name="location" class="form-control" id="">
                                @error('location')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                   <div class="row mt-3">
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">{{ __('lang.Update') }}</button>
                    </div>
                   </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- CONTENT AREA -->
@endsection

