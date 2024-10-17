@extends('layout.default', [])

@section('title', 'Home')

@push('css')
    <link href="{{asset('assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/bootstrap-table/dist/bootstrap-table.min.css')}}" rel="stylesheet">
    <!-- extra css here -->
@endpush

@push('js')
    <!-- extra js here -->
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
            url: "{{ route('patient.data') }}",
            method: "POST",
            data: function(d) {
                d._token = "{{ csrf_token() }}";
                if($('#search').val()) {
                    d.hospital = $('#search').val();
                }
            },
            error: function(request, status, error) {
                console.log(request.responseText);
            }
        }),
        columns: [
            {data: 'fullname', name: 'name'},
            {data: 'hospital_no', name: 'Hospital No'},
            {data: 'date_admitted', name: 'Date Admitted'},
            {data: 'diagnosis', name: 'diagnosis'},
            {data: 'gendervalue', name: 'gender'},
            {data: 'action', name: 'action'},
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
    <!-- page header -->
    <h1 class="page-header">
        Welcome to ICU Monitor
    </h1>
    <!--Begin Row -->
    <div class="row">
        <div class="col-sm-6 mb-3 d-flex flex-column">
            <!-- BEGIN card -->
            <div class="card mb-3 flex-1">
                <!-- BEGIN card-body -->
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div class="flex-grow-1">
                            <h5 class="mb-1">Total No. of Beds</h5>

                        </div>

                    </div>

                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h3 class="mb-1">{{$bed_count}}</h3>

                        </div>
                        <div
                            class="w-50px h-50px bg-primary bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fa fa-bed fa-lg text-primary"></i>
                        </div>
                    </div>
                </div>
                <!-- END card-body -->
            </div>
            <!-- END card -->
        </div>
        <div class="col-sm-6 mb-3 d-flex flex-column">
            <!-- BEGIN card -->
            <div class="card mb-3 flex-1">
                <!-- BEGIN card-body -->
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div class="flex-grow-1">
                            <h5 class="mb-1">Total No. of Occupied Beds</h5>

                        </div>

                    </div>

                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <h3 class="mb-1">{{$occupied}}</h3>

                        </div>
                        <div
                            class="w-50px h-50px bg-primary bg-opacity-20 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fas fa-bed fa-lg text-primary"></i>
                        </div>
                    </div>
                </div>
                <!-- END card-body -->
            </div>
            <!-- END card -->

        </div>

    </div>
    <!--End Row -->
    <div id="datatable" class="mb-5">

        <div class="card">
            <div class="card-body">
                <table id="datatableDefault" class="table w-full">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Hospital No</th>
                            <th>Date Admitted</th>
                            <th>Diagnosis</th>
                            <th>Gender</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>

    </div>


@endsection
