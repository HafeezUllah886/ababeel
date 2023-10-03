@php
    $page_title = 'Sale';
    $page_dir = 'Sale';
    $active = 'outflow';
    $menu = 'closed';
@endphp

@push('extra_css')
    <link href="{{ asset('assets/src/plugins/src/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/src/plugins/src/glightbox/glightbox.min.css') }}">
@endpush
@push('extra_js')
    <script src="{{ asset('assets/src/plugins/src/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('/assets/src/plugins/src/glightbox/glightbox.min.js') }}"></script>

    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
        $('#form').submit(function(e) {
            e.preventDefault();
            var product = $('#normalize').find(":selected").val();
            var unit = $('#unit').find(":selected").val();
            var warehouse = $('#warehouse').find(":selected").val();
            var width = $('#width').val();
            var length = $('#length').val();
            var sqf = $('#sqf').val();
            var qty = $('#qty').val();
            var price = $('#price').val();
            var id = $('#id').val();

            $('#product_msg').html('');
            $('#unit_msg').html('');
            $('#warehouse_msg').html('');
            $('#width_msg').html('');
            $('#length_msg').html('');
            $('#sqf_msg').html('');
            $('#qty_msg').html('');
            $('#price_msg').html('');

            if (product == '') {
                $('#product_msg').html('Please Select Product');
                return false;
            }
            if (unit == '') {
                $('#unit_msg').html('Please Select Unit');
                return false;
            }
            if (warehouse == '') {
                $('#warehouse_msg').html('Low Stock');
                return false;
            }
            if (unit == 'Piece') {
                if (width == '') {
                    $('#width_msg').html('Please Enter Width');
                    return false;
                }
                if (length == '') {
                    $('#length_msg').html('Please Enter Length');
                    return false;
                }
                if (sqf == '') {
                    $('#sqf_msg').html('Square feet is required');
                    return false;
                }
            }
            if (qty == '') {
                $('#qty_msg').html('Enter Quantity');
                return false;
            }
            if (price == '') {
                $('#price_msg').html('Enter Selling Price');
                return false;
            }
            $.ajax({
                method: "get",
                data: $("#form").serialize(),
                url: "{{ url('/outflow/add_pro') }}",
                success: function(result) {
                    console.log(result);
                    if (result == 'exists') {
                        var msg = "Product Already Exists";
                        Snackbar.show({
                            text: msg,
                            duration: 3000,
                            actionTextColor: '#fff',
                            backgroundColor: '#e7515a'
                        });
                    } else {
                        get_items();
                        $('#qty1').val('');
                        $('#price1').val('');
                        var selectized = $('#normalize').selectize();
                        selectized[0].selectize.focus();
                    }
                }
            });
        });

        $(document).ready(function() {
            var selectized = $('#normalize').selectize();
            var selectized1 = $('#normalize1').selectize();
            /* selectized[0].selectize.focus(); */
            get_items();
            $("#width_box").css('display', 'none');
            $("#length_box").css('display', 'none');
            $("#sqf_box").css('display', 'none');
            $("#amount_box").css('display', 'none');
            check_customer();
            check_isPaid();
        });

        function get_unit() {
            var product = $('#normalize').find(":selected").val();
            $("#unit").html("");
            $.ajax({
                method: "get",
                url: "{{ url('/get_unit/') }}/" + product,
                success: function(result) {
                    if (result == 'Nos') {
                        $("#unit").append("<option value=''></option><option value='Nos'>Nos</option>");
                    }
                    if (result == 'Roll') {
                        $("#unit").append("<option value=''></option><option value='Roll'>Roll</option><option value='Piece'>Piece</option>");
                    }
                    get_warehouse()
                }
            });
        }
        function get_price() {
            var product = $('#normalize').find(":selected").val();
            var unit = $("#unit").find(":selected").val();
            $.ajax({
                method: "get",
                url: "{{ url('/get_price/') }}/" + product,
                success: function(result) {
                    if(unit == "Piece") {
                        var price = result.sqf_price;
                        $("#price").val(price);
                        $("#width").attr("max", result.width);
                        $("#length").attr("max", result.length);
                        $("#width").val(result.width);
                        $("#length").val(result.length);
                        calculateSQF();
                    }
                    else{
                        $("#price").val(result.price);
                    }
                }
            });
        }
        function get_qty() {
            var product = $('#normalize').find(":selected").val();
            var unit = $("#unit").find(":selected").val();
            $.ajax({
                method: "get",
                url: "{{ url('/get_qty/') }}/" + product,
                success: function(result) {
                    if(unit == "Piece") {
                        var sqf = (result.width * result.length) * result.qty;
                       $("#qtyMsg").html(Math.round(sqf)+" Square Feets available in stock");
                       var order_size = $("#sqf").val();
                       $("#qty").attr("max", sqf / order_size);
                    }
                    else{
                        $("#qty").attr("max", result.qty);
                        $("#qtyMsg").html(result.qty+" available in stock");
                    }
                }
            });
        }
        function get_warehouse() {
            var product = $('#normalize').find(":selected").val();
            $('#warehouse').html("");
            $.ajax({
                method: "get",
                url: "{{ url('/get_warehouse/') }}/" + product,
                success: function(warehouses) {
                    $.each(warehouses, function(index, warehouse) {
                        $('#warehouse').append($('<option>', {
                            value: warehouse.id,
                            text: warehouse.name
                        }, "</option>"));
                    });
                }
            });
        }

        function get_items() {
            var id = $('#id').val();
            $.ajax({
                method: "get",
                url: "{{ url('/outflow/get_items/') }}/" + id,
                success: function(result) {

                    $("#items").html(result);
                }
            });
        }

        function delete1(id) {
            console.log('working');
            $.ajax({
                method: "get",
                url: "{{ url('/outflow/delete/item/') }}/" + id,
                success: function(msg) {
                    get_items();
                }
            });
        }

        function printPage(id) {
            var printWindow = window.open("{{ url('/outflow/pdf/') }}/" + id, '_blank');
            printWindow.onload = function() {
                printWindow.print();
                setTimeout(function() {
                    printWindow.close();
                }, 2000); // Delay in milliseconds (1 second)
            };
        }

        function calculateSQF() {
            var length = $("#length").val();
            var width = $("#width").val();

            if (length != "" && width != "") {
                var sqf = length * width;
                $("#sqf").val(sqf);
            }
            get_qty();
        }

        $("#unit").on("change", function(event) {
            event.stopPropagation();
            var unit = $("#unit").find(":selected").val();
            $("#price_per").html("");
            if (unit == "Piece") {
                $("#width_box").css("display", "block");
                $("#length_box").css("display", "block");
                $("#sqf_box").css("display", "block");
                $("#price_per").html("(per sqf)");
            } else {
                $("#width_box").css("display", "none");
                $("#length_box").css("display", "none");
                $("#sqf_box").css("display", "none");
            }
            get_price();
            get_qty();
        });


        function check_customer(){
            var customer = $("#normalize1").find(":selected").val();
            if(customer == 1)
            {
                $("#isPaid").val("yes");
                $("#isPaid_box").css("display","none");
            }
            else{
                $("#isPaid_box").css("display","block");
            }
            check_isPaid();
        }

    function check_isPaid(){
        var isPaid = $("#isPaid").find(":selected").val();
        if(isPaid == "yes")
        {
            $("#paidIn_box").css("display","block");
            $("#amount_box").css("display","none");
            $("#amount").val('');
        }
        else if(isPaid == "no"){
            $("#paidIn_box").css("display","none");
            $("#amount_box").css("display","none");
            $("#paidIn").val('');
            $("#amount").val('');
        }
        else
        {
            $("#paidIn_box").css("display","block");
            $("#amount_box").css("display","block");

        }
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
                        <h5>Create Invoice</h5>
                        <div>
                            <button onclick="printPage({{ $id }})" class="btn btn-info">Print</button>
                            <a href="{{ url('/product/add') }}" class="btn btn-success">Add New Product</a>
                        </div>
                    </div>
                    <form method="get" id="form" class="mt-3">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" id="id" name="id" value="{{ $bill_details->id }}">
                                <div class="form-group mt-3">
                                    <label for="normalize">Product</label>
                                    <select id="normalize" onchange="get_unit()" name="product">
                                        <option value=""></option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->code }} |
                                                {{ $product->color }} | {{ round($product->width, 2) }} x
                                                {{ round($product->length, 2) }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="product_msg"></span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group mt-3">
                                    <label for="unit">Unit</label>
                                    <select name="unit" class="form-control" id="unit"></select>
                                    <span class="text-danger" id="unit_msg"></span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group mt-3">
                                    <label for="warehouse">Warehouse</label>
                                    <select name="warehouse" class="form-control" id="warehouse"></select>
                                    <span class="text-danger" id="warehouse_msg"></span>
                                </div>
                            </div>
                            <div class="col-6 col-md-2" id="width_box">
                                <div class="form-group mt-3">
                                    <label for="width">Width (Feet)</label>
                                    <input type="number" name="width" step="any" id="width" onfocusout="calculateSQF()"
                                        class="form-control">
                                    <span class="text-danger" id="width_msg"></span>
                                </div>
                            </div>
                            <div class="col-6 col-md-2" id="length_box">
                                <div class="form-group mt-3">
                                    <label for="length">Length (Feet)</label>
                                    <input type="number" name="length" step="any" onfocusout="calculateSQF()" id="length"
                                        class="form-control">
                                    <span class="text-danger" id="length_msg"></span>
                                </div>
                            </div>
                            <div class="col-6 col-md-2" id="sqf_box">
                                <div class="form-group mt-3">
                                    <label for="sqf">{{ __('lang.Sqf') }}</label>
                                    <input type="number" name="sqf" id="sqf" class="form-control flatpickr-input"
                                        readonly>
                                    <span class="text-danger" id="sqf_msg"></span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group mt-3">
                                    <label for="qty">Quantity</label>
                                    <div class="input-group">
                                        <input type="number" id="qty" step="any" name="qty" class="form-control"
                                            placeholder="Enter Quantity">

                                    </div>
                                    <span class="text-danger" id="qty_msg"></span>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="form-group mt-3">
                                    <label for="price">Price <span id="price_per" class="text-warning"></span></label>
                                    <input type="number" placeholder="Enter purchasing rate" step="0.000000000000001" name="price"
                                        class="form-control" id="price">
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
                    <div class="alert alert-warning" id="qtyMsg"></div>
                    <div id="items" class="table-responsive"></div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex justify-content-between">
                        <h5>Update Invoice</h5>
                    </div>
                    <form method="post" action="{{ url('/outflow/edit/') }}/{{ $bill_details->id }}" class="mt-3" >
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                        <label for="normalize1">Customer</label>
                                        <select id="normalize1" onchange="check_customer()" name="customer">
                                            <option value=""></option>
                                             @foreach ($customers as $customer)
                                                 <option {{ $customer->id == $bill_details->customer->id ? 'selected' : '' }}  value="{{ $customer->id }}">{{ $customer->title }}</option>
                                             @endforeach
                                          </select>
                                          @error('customer')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="date">Date</label>
                                    <input type="date" name="date" value="{{ old('date', $bill_details->date) }}" class="form-control" id="date">
                                    @error('date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6" id="isPaid_box">
                                <div class="form-group mt-3">
                                    <label for="isPaid">Is Paid</label>
                                   <Select name="isPaid" id="isPaid" class="form-control" onchange="check_isPaid()">
                                    <option {{ $bill_details->isPaid == 'yes' ? 'selected' : '' }} value="yes">Yes</option>
                                    <option {{ $bill_details->isPaid == 'no' ? 'selected' : '' }} value="no">No</option>
                                    <option {{ $bill_details->isPaid == 'partial' ? 'selected' : '' }} value="partial">Partial</option>
                                   </Select>
                                    @error('isPaid')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6" id="amount_box">
                                <div class="form-group mt-3">
                                    <label for="amount">Amount</label>
                                    <input type="number" name="amount" step="any" value="{{ old('amount', $bill_details->amountPaid) }}" class="form-control" id="amount">
                                    @error('amount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6" id="paidIn_box">
                                <div class="form-group mt-3">
                                    <label for="paidIn">Paid In</label>
                                   <Select name="paidIn" id="paidIn" class="form-control">
                                    <option value="">Select</option>
                                        @foreach ($accounts as $account)
                                            <option {{ $account->id == @$bill_details->account->id ? 'selected' : '' }} value="{{ $account->id }}">{{ $account->title }}</option>
                                        @endforeach
                                   </Select>
                                    @error('paidIn')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="discount">Discount</label>
                                    <input type="number" name="discount" step="any" value="{{ old('discount', $bill_details->discount) }}" class="form-control" id="discount">
                                    @error('discount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="remarks">Remarks</label>
                                    <textarea name="remarks" value="{{ old('date', $bill_details->discount) }}" class="form-control" id="remarks"></textarea>
                                    @error('remarks')
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
