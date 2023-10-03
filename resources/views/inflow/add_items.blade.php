@php
    $page_title = "Purchase";
    $page_dir = "Purchase";
    $active = "inflow";
    $menu = "closed";
@endphp

@push('extra_css')
<link href="{{asset('assets/src/plugins/src/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/src/plugins/src/glightbox/glightbox.min.css')}}">
@endpush
@push('extra_js')

    <script src="{{asset('assets/src/plugins/src/bootstrap-select/bootstrap-select.min.js')}}"></script>
    <script src="{{ asset('/assets/src/plugins/src/glightbox/glightbox.min.js')}}"></script>


<!-- END PAGE LEVEL SCRIPTS -->
<script>
    $('#form').submit(function (e) {
        e.preventDefault();
        return false;
    });
    $(document).ready(function(){
var selectized = $('#normalize').selectize();
/* selectized[0].selectize.focus(); */
get_items();
});

$('#add_btn').on('click', function(){
    var data = $("#form").serialize();
$.ajax({
 method: "get",
 data: data,
 url: "{{url('/inflow/add_pro')}}",
 success: function(result){
    console.log(result);
     if(result == 'exists'){
         var msg = "Product Already Exists";
         Snackbar.show({
         text: msg,
         duration: 3000,
         actionTextColor: '#fff',
         backgroundColor: '#e7515a'
         });
     }
     else{
         get_items();
        $('#qty1').val('');
        $('#price1').val('');
        var selectized = $('#normalize').selectize();
        selectized[0].selectize.focus();
     }
 }
});
});


function get_unit(){
    var product = $('#normalize').find(":selected").val();
 $.ajax({
 method: "get",
 url: "{{url('/get_unit/')}}/"+product,
 success: function(result){
     $(".unit").html(result);
 }
});
get_price();
}

function get_price(){
    var product = $('#normalize').find(":selected").val();
 $.ajax({
 method: "get",
 url: "{{url('/inflow/get_price/')}}/"+product,
 success: function(result){
     $("#price1").val(result);
 }
});
}
function get_items(){
 var id = $('#id').val();
 $.ajax({
 method: "get",
 url: "{{url('/inflow/get_items/')}}/"+id,
 success: function(result){
     $("#items").html(result);
 }
});
}

function up_qty(id){
    var qty = $("#qty"+id).val();
    console.log(qty);
    $.ajax({
    method: "get",
    url: "{{url('/inflow/update/qty/')}}/"+id+"/"+qty,
    success: function(result){
     if(result == '0'){
         var msg = "Wrong Quantity";
         Snackbar.show({
         text: msg,
         duration: 3000,
         actionTextColor: '#fff',
         backgroundColor: '#e7515a'
         });
     }
     else{
        var msg = "Quantity Updated";
        Snackbar.show({
        text: msg,
        duration: 3000,
        actionTextColor: '#fff',
        backgroundColor: '#00ab55'
        });
        get_items();
     }
    }
});
}

function up_price(id){
    var price = $("#price"+id).val();
    $.ajax({
    method: "get",
    url: "{{url('/inflow/update/price/')}}/"+id+"/"+price,
    success: function(priceResult){
     if(priceResult == '0'){
         var msg = "Wrong Price";
         Snackbar.show({
         text: msg,
         duration: 3000,
         actionTextColor: '#fff',
         backgroundColor: '#e7515a'
         });
     }
     else{
        var msg = "Price Updated";
        Snackbar.show({
        text: msg,
        duration: 3000,
        actionTextColor: '#fff',
        backgroundColor: '#00ab55'
        });
        get_items();
     }
    }
});
}

function delete1(id){
    console.log('working');
    $.ajax({
    method: "get",
    url: "{{url('/inflow/delete/item/')}}/"+id,
    success: function(msg){
        get_items();
    }
});
}

function printPage(id){
    var printWindow = window.open("{{url('/inflow/pdf/')}}/"+id, '_blank');
    printWindow.onload = function() {
    printWindow.print();
    setTimeout(function() {
      printWindow.close();
    }, 2000);
  };
}

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
                    <div>
                        <button onclick="printPage({{ $id }})" class="btn btn-info">Print</button>
                        <a href="{{ url('/product/add') }}" class="btn btn-success">Add New Product</a>
                    </div>
                </div>
                <form method="get" id="form" class="mt-3">
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <input type="hidden" id="id" name="id" value="{{ $bill_details->id }}">
                            <div class="form-group mt-3">
                                    <label for="normalize">Product</label>
                                    <select id="normalize" onchange="get_unit()" name="pro">
                                        <option value=""></option>
                                         @foreach ($products as $product)
                                             <option value="{{ $product->id }}">{{ $product->code }} | {{ $product->color }} | {{ round($product->width,2) }} x {{ round($product->length,2) }} {{ $product->unit }}</option>
                                         @endforeach
                                      </select>
                                      <span class="text-danger" id="product_msg"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mt-3">
                                    <label for="normalize">Warehouse</label>
                                    <select id="normalize" class="form-control" name="warehouse" id="warehouse">
                                        <option value=""></option>
                                         @foreach ($warehouses as $warehouse)
                                             <option value="{{ $warehouse->id }}">{{ $warehouse->name }} | {{ $warehouse->location }}</option>
                                         @endforeach
                                      </select>
                            </div>
                        </div>
                        <div class="col-6 col-md-2">
                            <div class="form-group mt-3">
                                <label for="qty">Quantity</label>
                                <div class="input-group">
                                    <input type="number" name="qty" id="qty" class="form-control" placeholder="Quantity" aria-label="Quantity" aria-describedby="basic-addon1">
                                    <span class="input-group-text unit" id="basic-addon1"> </span>
                                </div>
                                <span class="text-danger" id="qty_msg"></span>
                            </div>
                        </div>
                        <div class="col-6 col-md-2">
                            <div class="form-group mt-3">
                                <label for="price">Purchase Price</label>
                                <input type="number" placeholder="Purchasing rate" name="price" class="form-control" id="price1">
                                <span class="text-danger" id="price_msg"></span>
                            </div>
                        </div>
                    </div>

                   <div class="row mt-3">
                    <div class="col-12 d-flex justify-content-end">
                        <button id="add_btn" class="btn btn-primary mb-3">{{ __('lang.Add') }}</button>
                    </div>
                   </div>
                </form>
                <div id="items" class="table-responsive"></div>
            </div>
        </div>
    </div>


</div>
<!-- CONTENT AREA -->
@endsection

