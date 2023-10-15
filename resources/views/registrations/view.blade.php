@php
    $page_title = "Registrations";
    $page_dir = "View";
    $active = "View";
    $menu = "open";
@endphp
@push('extra_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/src/plugins/src/table/datatable/datatables.css')}}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/src/plugins/css/light/table/datatable/dt-global_style.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/src/plugins/css/dark/table/datatable/dt-global_style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/src/plugins/src/glightbox/glightbox.min.css')}}">
@endpush

@extends('layout.main')
@section('content')
    <!-- CONTENT AREA -->
<div class="row layout-top-spacing">

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 text-end">
                        @if($reg->status == 'Pending')
                            <p class="position-absolute top-0 end-0 badge bg-warning">{{ $reg->status }}</p>
                        @endif
                        @if($reg->status == 'Approved')
                            <p class="position-absolute top-0 end-0 badge bg-success">{{ $reg->status }}</p>
                        @endif
                        @if($reg->status == 'Rejected')
                            <p class="position-absolute top-0 end-0 badge bg-danger">{{ $reg->status }}</p>
                        @endif
                    </div>
                    <div class="col-sm-3">
                        <img src="{{ asset($reg->photo) }}" style="width:100%;" alt="">
                        <h3 class="mt-3">{{ $reg->name }}</h3>
                        <p class="btn btn-default" data-bs-toggle="modal" data-bs-target="#cnic">View CNIC</p>
                        <p class="btn btn-default" data-bs-toggle="modal" data-bs-target="#bCard">View Bar Council Card</p>
                        <p class="btn btn-default"  data-bs-toggle="modal" data-bs-target="#licenses">View Licenses</p>
                    </div>
                    <div class="col-sm-9">
                        <table class="table" width="100%">
                            <tr>
                                <td width="30%">Registration Id</td>
                                <td>{{ $reg->id }}</td>
                            </tr>
                            <tr>
                                <td>Father Name</td>
                                <td>{{ $reg->fname }}</td>
                            </tr>
                            <tr>
                                <td>CNIC Number</td>
                                <td>{{ $reg->cnic }}</td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>{{ $reg->gender }}</td>
                            </tr>
                            <tr>
                                <td>Date of Birth</td>
                                <td>{{ date("d M Y", strtotime($reg->dob)) }}</td>
                            </tr>
                            <tr>
                                <td>District</td>
                                <td>{{ $reg->dist }}</td>
                            </tr>
                            <tr>
                                <td>Date of LC</td>
                                <td>{{ date("d M Y", strtotime($reg->lc)) }}</td>
                            </tr>
                            <tr>
                                <td>Date of HC</td>
                                <td>{{ date("d M Y", strtotime($reg->hc)) }}</td>
                            </tr>
                            <tr>
                                <td>Date of SC</td>
                                <td>{{ date("d M Y", strtotime($reg->sc)) }}</td>
                            </tr>
                            <tr>
                                <td>Bar Registration Number</td>
                                <td>{{ $reg->barReg }}</td>
                            </tr>
                            <tr>
                                <td>Phone Number</td>
                                <td>{{ $reg->phone }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $reg->email }}</td>
                            </tr>
                            <tr>
                                <td>Office Address</td>
                                <td>{{ $reg->addr }}</td>
                            </tr>
                        </table>
                        <div class="d-flex justify-content-end">
                            <a href="{{ url('/registraion/changeStatus/') }}/{{ $reg->id }}/Pending" class="btn btn-warning" style="margin-left: 5px">Pending</a>
                            <a href="{{ url('/registraion/changeStatus/') }}/{{ $reg->id }}/Rejected" class="btn btn-danger" style="margin-left: 5px">Reject</a>
                            <a href="{{ url('/registraion/changeStatus/') }}/{{ $reg->id }}/Approved" class="btn btn-success" style="margin-left: 5px">Approve</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cnic" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md"> <!-- Add "modal-dialog-white" class -->
        <div class="modal-content" style="background-color: white; color: #000000"> <!-- Add "modal-content-white" class -->
            <div class="modal-header">
                <h5 class="modal-title" id="addPaymentModalLabel" style="color: black; font-weight: bold">CNIC View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ asset($reg->cnicF) }}" class="w-100" alt="">
                <img src="{{ asset($reg->cnicB) }}" class="w-100" alt="">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="bCard" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md"> <!-- Add "modal-dialog-white" class -->
        <div class="modal-content" style="background-color: white; color: #000000"> <!-- Add "modal-content-white" class -->
            <div class="modal-header">
                <h5 class="modal-title" id="addPaymentModalLabel" style="color: black; font-weight: bold">Bar Council Card View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="{{ asset($reg->bCard) }}" class="w-100" alt="">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="licenses" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Add "modal-dialog-white" class -->
        <div class="modal-content" style="background-color: white; color: #000000"> <!-- Add "modal-content-white" class -->
            <div class="modal-header">
                <h5 class="modal-title" id="addPaymentModalLabel" style="color: black; font-weight: bold">Licenses View</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <embed src="{{ asset($reg->licenses) }}" class="w-100" style="min-height: 100vh"  type="text/pdf">
            </div>
        </div>
    </div>
</div>
<!-- CONTENT AREA -->

@endsection

@push('extra_js')
<script src="{{ asset('assets/src/plugins/src/jquery-ui/jquery.min.js') }}"></script>
<script src="{{ asset('assets/src/plugins/src/table/datatable/datatables.js') }}"></script>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ asset('/assets/src/plugins/src/glightbox/glightbox.min.js')}}"></script>
<script src="{{ asset('/assets/src/plugins/src/glightbox/custom-glightbox.min.js')}}"></script>
<!-- END PAGE LEVEL SCRIPTS -->
    <script>
        $('#zero-config').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
               "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10,
            "ordering": false,
        });
    </script>
@endpush
