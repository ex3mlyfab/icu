@extends('layout.default', [
    'appTopNav' => true,
	'appSidebarHide' => true,
	'appClass' => 'app-with-top-nav app-without-sidebar'
])

@section('title', 'Create Role')

@push('css')

@endpush

@push('js')
    <script>
        $(document).ready(function() {
            loadRoles();

    });
    function loadRoles() {
        $.ajax({
            url: '{{ route('role.get') }}',
            method: 'GET',
            success: function(response) {
                $('#role-table tbody').empty();
               $.each(response, function(index, role) {
                    $('#role-table tbody').append(`
                        <tr>
                            <td>${role.name}</td>
                            <td>
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    `);
                });
            }
        });
    }

    </script>
@endpush

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card shadow mb-1">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h1>Roles</h1>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                    data-bs-target="#modal-perm">Add New Role</button>
            </div>

        </div>
    </div>
</div>
<!--Begin Row -->
<div class="row mt-3">
    <div class="mb-3">
        <input type="text" class="form-control" id="search-input" placeholder="Search by name">
    </div>
   <div class="row px-md-4" id="role-list" >
        <div class="table-responsive">
            <table class="table table-bordered" id="role-table">
                <thead class="bg-theme opacity-5">
                    <tr>
                        <th class="border-1">Role Name</th>
                        <th class="border-1 text-center">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>


@endsection
