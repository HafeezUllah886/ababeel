@php
    $page_title = "Users";
    $page_dir = "Users";
    $active = "users";
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
                    <h5>{{__('lang.Roles')}}</h5>
                    <div class="d-flex justify-content-end">
                        <a href="{{ url('/users') }}" class="btn btn-info" style="margin-right:10px;">Users</a>
                        @can('Add Role')
                            <a href="{{ url('/roles/add') }}" class="btn btn-success">Add Role</a>
                        @endcan
                        
                    </div>

                </div>
                <div class="resposive-table">
                    <table id="zero-config" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @php
                                $ser = 0;
                            @endphp
                            @foreach ($roles as $role)
                            @php
                                $ser += 1;
                            @endphp
                                <tr>
                                    <td> {{ $ser }}</td>
                                    <td> {{ $role->name }}</td>

                                    <td>
                                        @can('Edit Role')
                                        <a href="{{url('/role/edit/')}}/{{$role->id}}" class="text-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>
                                        @endcan
                                        @can('Delete Role')
                                        /<a href="{{url('/role/delete/')}}/{{$role->id}}" class="text-danger confirmation"><svg xmlns="http://www.w3.org/2000/svg" class="text-danger" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
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

        var elems = document.getElementsByClassName('confirmation');
        var confirmIt = function (e) {
            if (!confirm('Are you sure to delete Role?')) e.preventDefault();
        };
        for (var i = 0, l = elems.length; i < l; i++) {
            elems[i].addEventListener('click', confirmIt, false);
        }
    </script>
@endpush
