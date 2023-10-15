@php
    $page_title = "Registrations";
    $page_dir = $type;
    $active = $type;
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
                <div class="card-title d-flex justify-content-between">
                    <h5>Registrations</h5>
                    <div class="card-actions">
                        <a href="{{ url('/dashboard') }}" class="btn btn-dark d-none d-sm-inline-block">
                            <i class="fas fa-plus"></i> Dashboard
                        </a>
                    </div>
                </div>
                <div class="resposive-table">
                    <table id="zero-config" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <th>#</th>
                            <th>Picture</th>
                            <th>Name</th>
                            <th>F/Name</th>
                            <th>CNIC</th>
                            <th>Reg Date</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($registrations as $reg)
                                <tr>
                                    <td> {{ $reg->id }}</td>
                                    <td> <img src="{{ asset($reg->photo) }}" style="width:50px;height:60px;" alt=""></td>
                                    <td> {{ $reg->name }}</td>
                                    <td> {{ $reg->fname }}</td>
                                    <td> {{ $reg->cnic }}</td>
                                    <td> {{ date('d M Y', strtotime($reg->date)) }}</td>
                                    <td>
                                        @can('Edit User')
                                            <a href="{{ url('/registration/view/') }}/{{ $reg->id }}" class="btn btn-primary">View</a>
                                        @endcan

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
