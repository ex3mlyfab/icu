@extends('layout.default',  [
    'appTopNav' => true,
	'appSidebarHide' => true,
	'appClass' => 'app-with-top-nav app-without-sidebar'
])

@section('title', 'Beds Information')

@push('css')
    <link href="{{asset('assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/bootstrap-table/dist/bootstrap-table.min.css')}}" rel="stylesheet">
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
        searching: false,
        ajax: ({
            url: "{{ route('bed.datatable') }}",
            method: "POST",
            data: function(d) {
                d._token = "{{ csrf_token() }}";
                if($('#search').val()) {
                    d.name = $('#search').val();
                }
            },
            error: function(request, status, error) {
                console.log(request.responseText);
            }
        }),
        columns: [
            {data: 'section', name: 'section'},
            {data: 'name', name: 'name'},
            {data: 'description', name: 'description'},
            {data: 'occupancy', name: 'occupancy'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action',  className: 'text-center'},
        ],
		dom: "<'row mb-3'<'col-md-4 mb-3 mb-md-0'l><'col-md-8 text-right'<'d-flex justify-content-end'f<'ms-2'B>>>>t<'row align-items-center mt-3'<'mr-auto col-md-6'i><'mb-0 col-md-6'p>>",
		lengthMenu: [ 10, 20, 30, 40, 50 ],
		responsive: true,
		buttons: [
			{ extend: 'print', className: 'btn btn-default btn-sm' },
			{ extend: 'csv', className: 'btn btn-default btn-sm' }
		]
	});

});
</script>


@endpush

@section('content')

<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-3">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h1>Bed Information</h1>
                    <a href="{{route('bed.create')}}" class="btn btn-primary">Add new Bed</a>
                </div>

            </div>
        </div>
    </div>
    <div id="datatable" class="mb-5">

        <div class="card">
            <div class="card-body">
                <table id="datatableDefault" class="table w-full">
                    <thead>
                        <tr>
                            <th>Section</th>
                            <th>Bed No</th>

                            <th>Description</th>
                            <th>Occupancy</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>

    </div>

</div>
@endsection
