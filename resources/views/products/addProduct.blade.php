@php
    $page_title = 'Add Product';
    $page_dir = 'AddProduct';
    $active = 'products';
    $menu = 'closed';
@endphp
@extends('layout.main')
@section('content')
    <!-- CONTENT AREA -->
    <div class="row layout-top-spacing">
        <div class="col-12 d-flex justify-content-end mb-3">
            <a href="{{ url('/products') }}" class="btn btn-dark">{{ __('lang.GoBack') }}</a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h5>{{ __('lang.AddNewProduct') }}</h5>
                    </div>
                    <form method="post" class="mt-3" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="code">{{ __('lang.Code') }}</label>
                                    <input type="text" placeholder="Enter code for product" name="code"
                                        class="form-control" id="">
                                    @error('code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="color">{{ __('lang.Color') }}</label>
                                    <input type="text" placeholder="Enter product color" name="color"
                                        class="form-control" id="">
                                    @error('color')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="code">{{ __('lang.PurchasePrice') }}</label>
                                    <input type="text" placeholder="Enter purchase price" name="purchase_price"
                                        class="form-control" id="">
                                    @error('purchase_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="code">{{ __('lang.SalePrice') }}</label>
                                    <input type="text" placeholder="Enter sale price" name="sale_price"
                                        class="form-control" id="">
                                    @error('sale_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="code">{{ __('lang.SqfPrice') }}</label>
                                    <input type="text" placeholder="Enter Price per Square Feet" name="sqf_price"
                                        class="form-control" id="">
                                    @error('sqf_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="base_unit">{{ __('lang.BaseUnit') }}</label>
                                    <select name="base_unit" class="form-control">
                                        <option>Roll</option>
                                        <option>Nos</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="width">Width (Feet)</label>
                                    <input type="number" step="any" name="width" id="width" onfocusout="calculateSQF()"  placeholder="Enter width is Feets" class="form-control">
                                    @error('width')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="length">Length (Feet)</label>
                                    <input type="number" step="any" name="length" onfocusout="calculateSQF()" id="length" placeholder="Enter length is Feets" class="form-control">
                                    @error('length')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="unit">{{ __('lang.Sqf') }}</label>
                                    <input type="number" name="sqf" id="sqf" class="form-control flatpickr-input" placeholder="Total Square Feets" readonly>
                                    @error('sqf')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group mt-3">
                                    <label for="image">{{ __('lang.Image') }}</label>
                                    <input type="file" name="image" class="form-control">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                    <button type="sublit" class="form-control btn btn-success" style="margin-top: 50px">Add Product</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- CONTENT AREA -->
@endsection
@push('extra_js')
    <script>
        function calculateSQF(){
            /* var unit = $("#unit").find(":selected").val(); */
            var length = $("#length").val();
            var width = $("#width").val();

           if(length != "" && width != "")
           {

            $("#sqf").val(length * width);
           /*  $.ajax({
            "method": "GET",
            "url": "{{ url('/calculateSQF/') }}/"+unit+"/"+width+"/"+length,
            "success": function(response) {
                console.log(response);
                $("#sqf").val(response);
            }
           }); */
           }
        }
    </script>
@endpush
