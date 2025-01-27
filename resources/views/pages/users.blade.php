@extends('layout.default', [
    'appTopNav' => true,
    'appSidebarHide' => true,
    'appClass' => 'app-with-top-nav app-without-sidebar',
])

@section('title', 'Users List')

@push('css')
  <link href="{{asset('assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet">
     <link href="{{ asset('assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/bootstrap-table/dist/bootstrap-table.min.css')}}" rel="stylesheet">
      <link href="{{ asset('assets/plugins/summernote/dist/summernote-lite.css') }}" rel="stylesheet">
@endpush

@push('js')
    <script src="{{asset('assets')}}/plugins/datatables.net/js/dataTables.min.js"></script>
<script src="{{asset('assets')}}/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="{{asset('assets')}}/plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{asset('assets')}}/plugins/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<script src="{{asset('assets')}}/plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="{{asset('assets')}}/plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="{{asset('assets')}}/plugins/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="{{asset('assets')}}/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('assets')}}/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="{{asset('assets')}}/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script>
        $(document).ready(function() {


            var table = $('#datatableDefault').DataTable({
                processing: true,
                serverSide: true,
                ajax: ({
                    url: "{{ route('datatable.user') }}",
                    method: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        if ($('#search').val()) {
                            d.fullname = $('#search').val();
                        }
                    },
                    error: function(request, status, error) {
                        console.log(request.responseText);
                    }
                }),
                searching: false,
                columns: [{
                        data: 'first_name',
                        name: 'First Name'
                    },
                    {
                        data: 'last_name',
                        name: 'Last Name'
                    },
                    {
                        data: 'email',
                        name: 'Email'
                    },
                    {
                        data: 'role',
                        name: 'Role'
                    },
                    {
                        data: 'telephone',
                        name: 'Telephone'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-center'
                    },
                ],
                dom: "<'row mb-3'<'col-md-4 mb-3 mb-md-0'l><'col-md-8 text-right'<'d-flex justify-content-end'f<'ms-2'B>>>>t<'row align-items-center mt-3'<'mr-auto col-md-6'i><'mb-0 col-md-6'p>>",
                lengthMenu: [10, 20, 30, 40, 50],
                responsive: true,
                buttons: [{
                        extend: 'print',
                        className: 'btn btn-default btn-sm'
                    },
                    {
                        extend: 'csv',
                        className: 'btn btn-default btn-sm'
                    }
                ]
            });

        });
    </script>
@endpush

@section('content')
    <div class="container d-flex">
        <div class="flex-grow-1">
            <h5 class="mb-1">Users List</h5>
        </div>
        <div class="flex-shrink-0">
            <a href="{{ route('user.create') }}" class="btn btn-primary">Add User</a>
        </div>
    </div>
    <!--Begin Row -->
    <div class="container">
        <div class="card border-1 border-purple p-3 mt-3">
            <div class="table-responsive">
                <table id="datatableDefault" class="table text-nowrap w-100">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Other Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Telephone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection
