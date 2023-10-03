@php
    $page_title = "Edit Product";
    $page_dir = "Products";
    $active = "products";
    $menu = "closed";
@endphp
@extends('layout.main')
@section('content')
    <!-- CONTENT AREA -->
<div class="row layout-top-spacing">
    <div class="col-12 d-flex justify-content-end mb-3">
        <a href="{{url('/products')}}" class="btn btn-dark">{{ __('lang.GoBack') }}</a>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title"><h5>{{ __('lang.EditProduct') }}</h5> </div>
                <form method="post" action="{{ url('/product/update/') }}/{{ $product->id }}" class="mt-3" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                <label for="color">{{ __('lang.Code') }}</label>
                                <input type="text" name="color" class="form-control" disabled value="{{ $product->code }}">
                                @error('color')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                <label for="color">{{ __('lang.Color') }}</label>
                                <input type="text" placeholder="Enter product color" name="color" class="form-control" value="{{ $product->color }}">
                                @error('color')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                <label for="price">{{ __('lang.PurchasePrice') }}</label>
                                <input type="number" placeholder="Enter purchase price" name="purchase_price" value="{{ $product->purchase_price }}" class="form-control">
                                @error('purchase_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                <label for="price">{{ __('lang.SalePrice') }}</label>
                                <input type="number" placeholder="Enter product selling price" name="price" value="{{ $product->price }}" class="form-control">
                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                <label for="price">{{ __('lang.SqfPrice') }}</label>
                                <input type="number" placeholder="Enter price per unit" name="sqf_price" value="{{ $product->sqf_price }}" class="form-control">
                                @error('sqf_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                <label for="base_unit">{{ __('lang.BaseUnit') }}</label>
                                <select name="base_unit" class="form-control">
                                    <option {{ $product->unit == "Roll" ? 'Selected' : '' }}>Roll</option>
                                    <option {{ $product->unit == "Nos" ? 'Selected' : '' }}>Nos</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                <label for="width">{{ __('lang.Width') }}</label>
                                <input type="number" step="any" name="width" id="width" value="{{ $product->width }}" onfocusout="calculateSQF()" class="form-control">
                                @error('width')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                <label for="length">{{ __('lang.Length') }}</label>
                                <input type="number" step="any" name="length" value="{{ $product->length }}" onfocusout="calculateSQF()" id="length" class="form-control">
                                @error('length')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                <label for="unit">{{ __('lang.Sqf') }}</label>
                                <input type="number" name="sqf" id="sqf" class="form-control flatpickr-input" value="{{ $product->sqf }}" readonly>
                                @error('sqf')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-4">
                                <button type="sublit" class="form-control btn btn-success" style="margin-top: 50px">Update</button>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
    <div class="col-12 mt-3">
        <div class="card">
            <div class="card-body">
                <h5>{{ __('lang.ChangeProductImage') }}</h5>
                <div class="row">
                    <div class="col-sm-4">
                        <img src="{{ asset($product->img) }}" alt="" class="img-fluid">
                    </div>
                    <div class="col-sm-8 d-flex align-items-center">
                        <form action="{{ url('product/updateImage/') }}/{{ $product->id }}" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="form-group">
                                <label>{{ __('lang.SelectNewImage') }}</label>
                                <input type="file" name="image" id="" class="form-control">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-info mt-3">{{ __('lang.Update') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- CONTENT AREA -->
@endsection
@push('extra_js')
    <script>
         function calculateSQF(){
            var length = $("#length").val();
            var width = $("#width").val();

           if(length != "" && width != "")
           {

            $("#sqf").val(length * width);

           }
        }
    </script>
@endpush

