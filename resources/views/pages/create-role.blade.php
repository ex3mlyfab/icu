@extends('layout.default', [
    'appTopNav' => true,
	'appSidebarHide' => true,
	'appClass' => 'app-with-top-nav app-without-sidebar'
])

@section('title', 'Create New Role')

@push('css')

@endpush

@push('js')
<script>
    $(document).ready(function() {
        loadPermissions();
        let rowId = 0;
        const permissionIds = [];
        $('#skin-save-spinner').hide();


            $('#perm-list').on('change', '.permission-check', function() {
                if ($(this).is(':checked')) {
                    permissionIds.push($(this).val());
                } else {
                    permissionIds.splice(permissionIds.indexOf($(this).val()), 1);
                }
            });
    });

    function loadPermissions() {
        $.ajax({
            url: '{{ route('permission.all') }}',
            method: 'GET',
            success: function(response) {
                console.log(response);
                    $('#perm-list').empty();
                    $.each(response, function(index, permission) {
                        $('#perm-list').append(`
                            <div class="col-sm-4 col-md-3 mb-2">
                                <div class="card border-danger-subtle p-2">
                                <div class="form-check">
                                    <input class="form-check-input permission-check" type="checkbox" value="${permission.name}" name="permissions[] id="permission-${permission.id}" >
                                    <label class="form-check-label" for="permission-${permission.id}">${permission.name}</label>
                                </div>
                                </div>
                            </div>
                        `);
                });


            },
            error: function(err) {
                console.log(err);
            }
        });
    }

</script>
@endpush

@section('content')
<div class="container">
    <div class="row">
    <div class="col-xl-12">
        <div class="card shadow mb-1">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h1>Create New Role</h1>

            </div>

        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form id="perm-form" action="{{ route('role.create') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-skin">Role Name</span>
                                    <input type="text" id="skin-integrity" class="form-control" name="name"
                                        placeholder="Role Name" required>
                                </div>
                            </div>

                        </div>
                         <div class="row mt-3">

                         <h5>Select Role Permissions</h5>
                        <div id="perm-list" class="row border-1 border-teal-200 p-2">

                        </div>
                        <div id="pagination"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary" id="skin-save">Save</button>
                            </div>
                        </div>
                    </form>

</div>
@endsection
