@php
    $page_title = "Edit Account";
    $page_dir = "EditAccount";
    $active = "finance";
    $menu = "open";
@endphp
@extends('layout.main')
@section('content')
    <!-- CONTENT AREA -->
<div class="row layout-top-spacing">
    <div class="col-12 d-flex justify-content-end mb-3">
        <a href="{{url('/accounts')}}" class="btn btn-dark">{{ __('lang.GoBack') }}</a>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title"><h5>Edit Account</h5> </div>
                <form method="post" action="{{ url('/account/update/') }}/{{ $account->id }}" class="mt-3" >
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="title">Account Title</label>
                                <input type="text" name="title" value="{{ $account->title }}" placeholder="Enter account name" class="form-control" id="">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="contact">Contact Number</label>
                                <input type="text" name="contact" value="{{ $account->contact }}" placeholder="Enter contact number" class="form-control" id="">
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="desc">Description</label>
                                <input type="text" name="desc" value="{{ $account->desc }}" placeholder="Enter description" class="form-control" id="">
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

