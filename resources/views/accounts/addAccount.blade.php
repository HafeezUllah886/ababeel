@php
    $page_title = "Add Account";
    $page_dir = "AddAccount";
    $active = "finance";
    $menu = "open";
@endphp
@push('extra_js')
    <script>
        $("#cat_box").css("display","none");
        function check_type(){
            var type = $("#type").find(":selected").val();
            if(type== "Business")
            {
                $("#cat_box").css("display","block");
                $("#contact_box").css("display","none");
            }
            else{
                $("#contact_box").css("display","block");
                $("#cat_box").css("display","none");
            }
    }
    </script>
@endpush
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
                <div class="card-title"><h5>Add New Account</h5> </div>
                <form method="post" class="mt-3" >
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="title">Account Title</label>
                                <input type="text" name="title" placeholder="Enter account name" class="form-control" id="">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="code">Account Type</label>
                                <select name="type" id="type" onchange="check_type()" required class="form-control">
                                    <option> </option>
                                    <option> Business </option>
                                    <option> Customer </option>
                                    <option> Supplier </option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6" id="cat_box">
                            <div class="form-group mt-3">
                                <label for="code">Account Category</label>
                                <select name="cat" id="cat" class="form-control">
                                    <option> </option>
                                    <option> Cash </option>
                                    <option> Bank </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="contact_box">
                            <div class="form-group mt-3">
                                <label for="contact">Contact Number</label>
                                <input type="text" name="contact" placeholder="Enter contact number" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="contact">Initial Amount</label>
                                <input type="number" name="amount" placeholder="Enter initial amount" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mt-3">
                                <label for="desc">Description</label>
                                <textarea name="desc" placeholder="Enter description" class="form-control"></textarea>
                            </div>
                        </div>

                    </div>
                   <div class="row mt-3">
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">{{ __('lang.Save') }}</button>
                    </div>
                   </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- CONTENT AREA -->
@endsection

