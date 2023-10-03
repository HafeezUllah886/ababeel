@php
    $page_title = "Edit Role";
    $page_dir = "EditRole";
    $active = "dashboard";
    $menu = "open";
@endphp
@push('extra_js')
<script>
    const selectAllCheckbox = document.getElementById('select-all');
    const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');

    // Check the "Select All" checkbox based on the state of individual permission checkboxes
    function updateSelectAllCheckbox() {
        const allChecked = Array.from(permissionCheckboxes).every(checkbox => checkbox.checked);
        const someChecked = Array.from(permissionCheckboxes).some(checkbox => checkbox.checked);

        if (allChecked) {
            selectAllCheckbox.checked = true;
            selectAllCheckbox.indeterminate = false;
        } else if (someChecked) {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = true;
        } else {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = false;
        }
    }

    // Handle the "Select All" checkbox change event
    selectAllCheckbox.addEventListener('change', function() {
        for (const checkbox of permissionCheckboxes) {
            checkbox.checked = this.checked;
        }
        updateSelectAllCheckbox();
    });

    // Handle individual permission checkbox change events
    for (const checkbox of permissionCheckboxes) {
        checkbox.addEventListener('change', function() {
            updateSelectAllCheckbox();
        });
    }

    // Update the "Select All" checkbox state on page load
    updateSelectAllCheckbox();
</script>
@endpush
@extends('layout.main')
@section('content')
    <!-- CONTENT AREA -->
<div class="row layout-top-spacing">
    <div class="col-12 d-flex justify-content-end mb-3">
        <a href="{{url('/roles')}}" class="btn btn-dark">{{ __('lang.GoBack') }}</a>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title"><h5>Edit Role</h5> </div>
                <form method="post" action="{{ url('/role/update/') }}/{{ $role->id }}" class="mt-3" >
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mt-3">
                                <label for="title">Name</label>
                                <input type="text" name="name" placeholder="Enter role name" value="{{ $role->name }}" class="form-control" id="">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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

        <div class="card mt-3">
            <div class="card-body">
                <div class="card-title"><h5>Assign Permission(s)</h5> </div>
                <form method="post" action="{{ url('/role/assignPermissions/') }}/{{ $role->id }}" class="mt-3" >
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="select-all"
                                >
                                <label class="form-check-label" for="select-all">
                                    Select All
                                </label>
                            </div>
                        </div>
                        @foreach ($permissions as $permission)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input
                                        class="form-check-input permission-checkbox"
                                        type="checkbox"
                                        name="permissions[]"
                                        value="{{ $permission->name }}"
                                        {{ $role->getAllPermissions()->contains($permission) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="{{ $permission->name }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach

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



