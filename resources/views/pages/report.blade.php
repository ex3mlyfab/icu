@extends('layout.default', [
      'appTopNav' => true,
	'appSidebarHide' => true,
	'appClass' => 'app-with-top-nav app-without-sidebar'
])

@section('title', 'Report Generation')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link href="{{asset('assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet">
     <link href="{{ asset('assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/bootstrap-table/dist/bootstrap-table.min.css')}}" rel="stylesheet">
      <link href="{{ asset('assets/plugins/summernote/dist/summernote-lite.css') }}" rel="stylesheet">
@endpush

@push('js')
    <script src="{{ asset('assets/plugins/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
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
            $('#daterange').daterangepicker({
                opens: 'right',
                format: 'MM/DD/YYYY',
                separator: ' to ',
                startDate: moment().subtract('days', 29),
                endDate: moment(),
                minDate: '01/01/2012',
                maxDate: '12/31/2025',
            }, function (start, end) {
                $('#daterange input').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });
        var invoice_table = $('#server-side-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                    "searching": false,
                    'paginate': {
                    'previous': '<i class="fa fa-chevron-left"></i>',
                    'next': '<i class="fa fa-chevron-right"></i>'
                             },
                    ajax: ({
                        url: "{{ route('report.datatable') }}",
                        method: "POST",
                        data: function(d) {
                            d._token = $('meta[name="csrf-token"]').attr('content');

                            if ($('input[name=patient_name]').val() != '') {
                                d.last_name = $('input[name=patient_name]').val();
                            }

                            if ($('input[name=diagnosis]').val() != '') {
                            	d.diagnosis = $('input[name=diagnosis]').val();
                            }

                            if ($('input[name=daterange]').val() != '') {
                            	d.daterange = $('input[name=daterange]').val();
                            }
                        },
                        error: function(request, status, error) {
                            console.log(request.responseText);
                        }
                    }),
                    columns: [
                        { data: 'fullname', name: 'patient_name' },
                        { data: 'diagnosis', name: 'diagnosis' },
                        { data: 'hospital_no', name: 'hospital_no', className: 'text-center', orderable: false },
                        { data: 'age', name: 'age' },
                        { data: 'gendervalue', name: 'Sex' },
                        { data: 'date_admitted', name: 'admission_date' },
                        { data: 'date_discharged', name: 'discharge_date' },
                        { data: 'days_spent', name: 'days_spent', className: 'text-left' },
                        { data: 'action', name: 'actions', className: 'text-center noExport', orderable: false }
                ],
                dom: "<'row mb-3'<'col-md-4 mb-3 mb-md-0'l><'col-md-8 text-right'<'d-flex justify-content-end'f<'ms-2'B>>>>t<'row align-items-center mt-3'<'mr-auto col-md-6'i><'mb-0 col-md-6'p>>",
		lengthMenu: [ 10, 20, 30, 40, 50 ],
		responsive: true,

		buttons: [
			{ extend: 'print', className: 'btn btn-default btn-sm', exportOptions: {
            columns: ":visible:not(.noExport)"
        } },
			{ extend: 'csv', className: 'btn btn-default btn-sm', exportOptions: {
            columns: ":visible:not(.noExport)"
        } },

            { extend: 'colvis', className: 'btn btn-default btn-sm' }
		]
	});
      $('#patient-name').on('keyup', function(e) {
                    invoice_table.draw();
                });
      $('#diagnosis').on('keyup', function(e) {
                    invoice_table.draw();
         });


     $('#date_range').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        format: 'YYYY-MM-DD',
                        cancelLabel: 'Clear'
                    }
                });

                $('#date_range').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                        'YYYY-MM-DD'));

                    invoice_table.draw();
                });

                $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                    invoice_table.draw();
                });


        });
    </script>

@endpush

@section('content')
<h1 class="page-header">
       Generate Report
</h1>
<div class="container">
    <div class="card border-danger mb-2 p-2 shadow-lg">
        <div class="card-title">
            <h6>Filter Report</h6>
        </div>
        <div class="card-body p-md-3">
            <div class="row">
                <div class="col-sm-12 col-lg-4">
                    <div class="form-group mb-3">
                        <label class="form-label" for="patient-name">Patient Name</label>
                        <input type="text" class="form-control" name="patient_name" id="patient-name" placeholder="Patient Name">
                    </div>
                </div>

                <div class="col-sm-12 col-lg-4">
                     <div class="form-group mb-3">
                        <label class="form-label" for="diagnosis">Diagnosis</label>
                        <input type="text" class="form-control"  name="diagnosis" id="diagnosis" placeholder="Diagnosis">
                    </div>
                </div>


                <div class="col-sm-12 col-lg-4">
                    <label class="form-label" >Date Admitted Range</label>
                    <div class="input-group" id="daterange">
                        <input type="text" name="daterange" id="date_range" class="form-control" value="" placeholder="click to select the date range">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="card border-theme p-2">
        <div class="responsive-table">
            <table class="table text-nowrap w-100" id="server-side-datatable">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Diagnosis</th>
                        <th>Hospital No</th>
                        <th>Age</th>
                        <th>Sex</th>
                        <th>Date Admitted</th>
                        <th>Date Discharged</th>
                        <th>Days Spent</th>
                        <th>Actions</th>
                    </tr>
                </thead>

            </table>

        </div>

    </div>


@endsection
