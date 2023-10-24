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
                    <table id="zero-config" class="table table-bordered table-striped table-hover" style="width:100%">
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
                                    <td> <img src="{{ asset($reg->photo) }}" style="width:70px;height:100px;" alt=""></td>
                                    <td> {{ $reg->name }}</td>
                                    <td> {{ $reg->fname }}</td>
                                    <td> {{ $reg->cnic }}</td>
                                    <td> {{ date('d M Y', strtotime($reg->date)) }}</td>
                                    <td>
                                        @if($reg->status == 'Pending')
                                        <a href="{{ url('/registraion/changeStatus/') }}/{{ $reg->id }}/Approve" class="btn btn-success btn-sm">Approved</a><br>
                                        <a href="{{ url('/registraion/changeStatus/') }}/{{ $reg->id }}/Rejected" class="btn btn-danger btn-sm">Rejected</a><br>

                                        @elseif($reg->status == "Rejected")
                                        <a href="{{ url('/registraion/changeStatus/') }}/{{ $reg->id }}/Approved" class="btn btn-success btn-sm">Approved</a><br>
                                        @elseif($reg->status == "Approved")

                                        <a href="{{ url('/registraion/changeStatus/') }}/{{ $reg->id }}/Rejected" class="btn btn-danger btn-sm">Rejected</a><br>
                                        @endif

                                        <a href="{{ url('/registraion/changeStatus/') }}/{{ $reg->id }}/Pending" class="btn btn-default btn-sm" data-bs-toggle="modal" data-bs-target="#pay_{{ $reg->id }}">Forward</a><br>
                                        <a href="{{ url('/registration/view/') }}/{{ $reg->id }}" class="btn btn-info btn-sm">View</a>
                                        {{-- <div class="dropdown">
                                            <button class="btn dropdown-toggle form-select" type="button" id="dropdownMenuButton_{{ $reg->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton_{{ $reg->id }}">
                                                <a class="dropdown-item" href="{{ url('/registraion/changeStatus/') }}/{{ $reg->id }}/Pending">
                                                    Mark as Pending
                                                </a>
                                                <a class="dropdown-item" href="{{ url('/registraion/changeStatus/') }}/{{ $reg->id }}/Rejected">
                                                    Mark as Rejected
                                                </a>
                                                <a class="dropdown-item" href="{{ url('/registraion/changeStatus/') }}/{{ $reg->id }}/Approved">
                                                    Mark as Approved
                                                </a>
                                            </div>
                                        </div> --}}
                                    </td>
                                </tr>
                                <div class="modal fade" id="pay_{{ $reg->id }}" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-md"> <!-- Add "modal-dialog-white" class -->
                                        <div class="modal-content" style="background-color: white; color: #000000"> <!-- Add "modal-content-white" class -->
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="payModalLabel" style="color: black; font-weight: bold">Forward Appication </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="{{ url('/app/forwarding/') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $reg->id }}">
                                                    <div class="form-group">
                                                        <label for="user">Forward to</label>
                                                        <select name="user" id="user" class="form-select">
                                                            @foreach ($users as $user)
                                                                <option value="{{ $user->id }}" {{ old('user') == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="notes">Notes</label>
                                                       <textarea name="notes" id="notes" class="form-control" cols="30" rows="10"></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <input class="btn btn-primary" type="submit" value="Forward">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
