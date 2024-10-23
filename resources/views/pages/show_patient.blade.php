@extends('layout.empty')

@section('title', 'patient_details')

@push('css')
    <link href="{{ asset('assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet">
@endpush

@push('js')
    <script src="{{ asset('assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/demo/dashboard.demo.js') }}"></script>
    <script>
        $('#timepicker-default').timepicker({
            defaultTime: 'current',
            showMeridian: false,
            minuteStep: 1
        });
        $('#timepicker-respiratoy').timepicker({
            defaultTime: 'current',
            showMeridian: false,
            minuteStep: 1
        });


        let activeDay = $('#active-day').val();


        // Store the GET function in a variable
        var getCardioData = function() {
            $.ajax({
                type: 'GET', // or 'POST' if required
                url: `{{ URL::to('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/cardio-assessment/${activeDay}`,
                dataType: 'json', // Specify the expected data format (e.g., JSON)
                success: function(data) {


                    // $('#chart-3').html(data.data);
                    let myData = data.data;
                    console.log(myData);
                    var table = $('<table class="table table-bordered"></table>');
                    var headerIndicator = $('<thead></thead>');
                    // Create a table header row
                    var headerRow = $('<tr></tr>');
                    headerRow.append('<th class="bg-yellow-300">label</th>');
                    for (var i = 0; i < myData.label.length; i++) {

                        headerRow.append('<th>' + myData.label[i] + '</th>');
                    }
                    headerIndicator.append(headerRow);
                    table.append(headerIndicator);

                    // Create table body rows
                    for (var key in myData) {
                        if (key !== "label") {
                            var row = $('<tr></tr>');
                            row.append('<th class="bg-yellow-300">' + key + '</th>');
                            for (var i = 0; i < myData[key].length; i++) {

                                row.append('<td>' + myData[key][i] + '</td>');
                            }
                            table.append(row);
                        }
                    }
                    $("#table-cardio").html(table);

                },
                error: function(error) {
                    // Handle errors
                    console.error(error);
                    // You can display an error message to the user here
                }
            });
        };
        var getRespData = function() {
            $.ajax({
                type: 'GET', // or 'POST' if required
                url: `{{ URL::to('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/resp-assessment/${activeDay}`,
                dataType: 'json', // Specify the expected data format (e.g., JSON)
                success: function(data) {


                    // $('#chart-3').html(data.data);
                    let respData = data.data;
                    var table = $('<table class="table table-bordered"></table>');
                    var headerIndicator = $('<thead></thead>');
                    // Create a table header row
                    var headerRow = $('<tr></tr>');
                    headerRow.append('<th class="bg-yellow-300">label</th>');
                    for (var i = 0; i < respData.label.length; i++) {

                        headerRow.append('<th>' + respData.label[i] + '</th>');
                    }
                    headerIndicator.append(headerRow);
                    table.append(headerIndicator);

                    // Create table body rows
                    for (var key in respData) {
                        if (key !== "label") {
                            var row = $('<tr></tr>');
                            row.append('<th class="bg-yellow-300">' + key + '</th>');
                            for (var i = 0; i < respData[key].length; i++) {

                                row.append('<td>' + respData[key][i] + '</td>');
                            }
                            table.append(row);
                        }
                    }
                    $("#table-resp").html(table);

                },
                error: function(error) {
                    // Handle errors
                    console.error(error);

                }
            });
        };
        getCardioData();
        getRespData();
        $('#cardio-save-spinner').hide();
        $('#cardio-form').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            var formData = $(this).serialize(); // Serialize form data
            $('#cardio-save').prop('disabled', true);
            $('#cardio-save-spinner').show();

            $.ajax({
                type: 'POST',
                url: '{{ route('cardio.store') }}', // Replace with your server-side script URL
                data: formData,
                success: function(response) {

                    console.log(response);
                    $('#toast-1 .toast-body').html(response.message);
                    $('#toast-1').toast('show');
                    $('#modalXl').modal('hide');

                    $('#cardio-form')[0].reset();
                    $('#cardio-save').prop('disabled', false);
                    $('#cardio-save-spinner').hide();
                    getCardioData();
                },
                error: function(error) {
                    // Handle errors$
                    console.error(error);
                    // You can display an error message to the user here
                    var errorMessage = error.responseJSON.message;
                    $('#toast-1 .toast-body').html(errorMessage);
                    $('#toast-1').toast('show');
                    $('#cardio-save').prop('disabled', false);
                    $('#cardio-save-spinner').hide();

                }
            });
        });
        $('#resp-save-spinner').hide();
        $('#resp-form').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            var respData = $(this).serialize(); // Serialize form data

            $('#resp-save').prop('disabled', true);
            $('#resp-save-spinner').show();

            $.ajax({
                type: 'POST',
                url: '{{ route('resp.store') }}', // Replace with your server-side script URL
                data: respData,
                success: function(response) {

                    console.log(response);
                    $('#toast-1 .toast-body').html(response.message);
                    $('#toast-1').toast('show');
                    $('#modalXl').modal('hide');

                    $('#resp-form')[0].reset();
                    $('#resp-save').prop('disabled', false);
                    $('#resp-save-spinner').hide();
                    getRespData();
                },
                error: function(error) {
                    // Handle errors$
                    console.error(error);
                    // You can display an error message to the user here
                    var errorMessage = error.responseJSON.message;
                    $('#toast-1 .toast-body').html(errorMessage);
                    $('#toast-1').toast('show');
                    $('#resp-save').prop('disabled', false);
                    $('#resp-save-spinner').hide();

                }
            });
        });

        $('#active-day').on('change', function() {
            activeDay = $('#active-day').val();
            getCardioData();
            getRespData();
        });
    </script>
@endpush

@section('content')
    <div class="toast-container">
        <div class="toast fade hide mb-3" data-autohide="false" id="toast-1">
            <div class="toast-header">
                <i class="far fa-bell text-muted me-2"></i>
                <strong class="me-auto">Success!</strong>

                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">

            </div>
        </div>
    </div>

    <div class="mx-2 mx-md-5 mt-2">
        <div class="card border-theme border-3  sticky-top">
            <div class="card-body row gx-0 align-items-center shadow-lg">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="d-flex flex-column">
                                <h4 class="mb-0"> Name: <span
                                        class=
                                    "fw-bold text-gray-emphasis">{{ $patient->fullname }}</span>
                                </h4>
                                <h5 class="text-muted my-0 text-teal-emphasis">Age: &nbsp;
                                    {{ (int) $patient->date_of_birth->diffInYears() }} Years
                                    {{ $patient->date_of_birth->diffInMonths() % 12 }} Months</h5>
                                <h5 class="text-muted my-0 text-gray-emphasis">Sex: &nbsp;{{ $patient->gender->name }}</h5>
                                <h5 class="text-muted my-0">Marital Status: &nbsp;{{ $patient->marital_status->name }}</h5>
                            </div>
                        </div>
                        <div class="col-md-3 border-start border-2 border-primary bg-gray-200 rounded">
                            <h5 class="text-muted my-0 text-gray-emphasis">Bed-No: &nbsp;<span
                                    class="fw-bold">{{ $patient->latestPatientCare->bedModel->name }} </span></h5>
                            <h5 class="text-muted my-0 text-gray-emphasis">Admission-Date: &nbsp;<span
                                    class="fw-bold">{{ $patient->latestPatientCare->admission_date->format('d/M/Y') }}</span>
                            </h5>
                            <h5 class="text-muted my-0 text-gray-emphasis">Diagnosis: &nbsp;<span
                                    class="fw-bold">{{ $patient->latestPatientCare->diagnosis }}</span></h5>
                            <h5 class="text-muted my-0 text-gray-emphasis"><span class="fw-bold">Admitted-From:
                                    &nbsp;</span>{{ $patient->latestPatientCare->admitted_from }}</h5>
                        </div>
                        <div class="col-md-3 border-start border-2 border-primary">
                            <h5 class="text-muted my-0 text-gray-emphasis"><span class="fw-bold">Condition: &nbsp;</span>
                                {{ $patient->latestPatientCare->notes }}</h5>
                            <h5 class="text-muted my-0 text-gray-emphasis"><span class="fw-bold">Consultant: &nbsp;</span>
                                {{ $patient->latestPatientCare->icu_consultant }}
                            </h5>
                            <h5 class="text-muted my-0 text-gray-emphasis"><span class="fw-bold">Nurse Incharge:
                                    &nbsp;</span>{{ $patient->latestPatientCare->nurse_incharge }}</h5>
                            <h5 class="text-muted my-0 text-gray-emphasis"><span class="fw-bold">Next of Kin:
                                    &nbsp;</span>{{ $patient->next_of_kin }}</h5>
                        </div>
                        <div class="col-md-3 border-start border-2 border-primary">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">DashBoard</a>
                            <div class="form-group row my-1 rounded bg-green-200 px-2 align-items-center">
                                <label for="active-day" class="form-label fw-bold">Active Day</label>

                                <select class="form-select form-select-lg mb-3" id="active-day">
                                    @foreach ($dates as $key => $date)
                                        <option value="{{ $date->format('Y-m-d') }}" @selected($date == today())>
                                            {{ $date->format('d-m-y') }} - Day {{ $key + 1 }}</option>
                                    @endforeach
                                </select>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row gy-2">
            <div class="col-lg-6">
                <div class="card h-100 mt-2">
                    <div class="card-header bg-yellow-300 d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-1">Cardiovascular Assessment</h5>
                        </div>
                        <div class="d-flex gap-2 align-items-center">

                            <i class="fa fa-plus" data-bs-toggle="modal" data-bs-target="#modalXl"></i>
                            <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                            <a href="#" data-toggle="card-expand"
                                class="text-white text-opacity-50 text-decoration-none"><i
                                    class="fa fa-fw fa-expand"></i></a>
                        </div>
                    </div>
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a href="#home-cardio" class="nav-link active" data-bs-toggle="tab">Tabular</a>
                            </li>
                            <li class="nav-item">
                                <a href="#table-cardio" class="nav-link" data-bs-toggle="tab">Chart</a>
                            </li>
                        </ul>
                    </div>

                    <!-- BEGIN card-body -->
                    <div class="card-body">
                        <div class="tab-content pt-3">
                            <div class="tab-pane fade show active" id="home-cardio">
                                <div class="table-responsive" id="table-cardio">

                                </div>


                            </div>
                            <div class="tab-pane fade" id="table-cardio">
                                <div id="chart"></div>
                            </div>
                        </div>


                    </div>
                    <!-- END card-body -->
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100 mt-2">
                    <div class="card-header  bg-dark d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-1 text-white">Respiratory Assessment</h5>
                        </div>
                        <div class="d-flex gap-2 align-items-center">

                            <i class="fa fa-plus text-white" data-bs-toggle="modal" data-bs-target="#modal-resp"></i>
                            <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                            <a href="#" data-toggle="card-expand"
                                class="text-white text-opacity-20 text-decoration-none"><i
                                    class="fa fa-fw fa-expand"></i></a>
                        </div>
                    </div>
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a href="#home-resp" class="nav-link active" data-bs-toggle="tab">Tabular</a>
                            </li>
                            <li class="nav-item">
                                <a href="#table-resp" class="nav-link" data-bs-toggle="tab">Chart</a>
                            </li>
                        </ul>
                    </div>

                    <!-- BEGIN card-body -->
                    <div class="card-body">
                        <div class="tab-content pt-3">
                            <div class="tab-pane fade show active" id="home-resp">
                                <div class="table-responsive" id="table-resp">

                                </div>


                            </div>
                            <div class="tab-pane fade" id="table-resp">
                                <div id="chart-resp"></div>
                            </div>
                        </div>


                    </div>
                    <!-- END card-body -->

                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100 mt-2">
                    <!-- BEGIN card-body -->
                    <div class="card-header bg-warning d-flex gap-2 align-items-center">

                            <div class="flex-grow-1">
                                <h5 class="mb-1">Fluid Balance</h5>

                            </div>
                            <i class="fa fa-plus" data-bs-toggle="modal" data-bs-target="#modal-fluid"></i>
                            <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                            <a href="#" data-toggle="card-expand"
                                class="text-white text-opacity-20 text-decoration-none"><i
                                    class="fa fa-fw fa-expand"></i></a>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="table-fluid">

                        </div>


                    </div>
                    <!-- END card-body -->
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100 mt-2">
                    <!-- BEGIN card-body -->
                    <div class="card-header bg-danger d-flex gap-2 align-items-center">

                            <div class="flex-grow-1">
                                <h5 class="mb-1">Neurological Assessment</h5>

                            </div>
                            <i class="fa fa-plus" data-bs-toggle="modal" data-bs-target="#modal-neuro"></i>
                            <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                            <a href="#" data-toggle="card-expand"
                                class="text-white text-opacity-20 text-decoration-none"><i
                                    class="fa fa-fw fa-expand"></i></a>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="table-neuro">

                        </div>


                    </div>
                    <!-- END card-body -->
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100 mt-2">
                    <!-- BEGIN card-body -->
                    <div class="card-header bg-gradient bg-warning-400 d-flex gap-2 align-items-center">

                            <div class="flex-grow-1">
                                <h5 class="mb-1">Medications</h5>

                            </div>
                            <i class="fa fa-plus" data-bs-toggle="modal" data-bs-target="#modal-neuro"></i>
                            <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                            <a href="#" data-toggle="card-expand"
                                class="text-white text-opacity-20 text-decoration-none"><i
                                    class="fa fa-fw fa-expand"></i></a>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="table-neuro">

                        </div>


                    </div>
                    <!-- END card-body -->
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100 mt-2">
                    <!-- BEGIN card-body -->
                    <div class="card-body">
                        <div class="d-flex mb-3 gap-1">
                            <div class="flex-grow-1">
                                <h5 class="mb-1">Laboratory Results</h5>

                            </div>
                            <i class="fa fa-plus" data-bs-toggle="modal" data-bs-target="#modal-resp"></i>
                            <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        </div>
                        <div id="chart-2"></div>
                    </div>
                    <!-- END card-body -->
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100 mt-2">
                    <!-- BEGIN card-body -->
                    <div class="card-body">
                        <div class="d-flex mb-3 gap-1">
                            <div class="flex-grow-1">
                                <h5 class="mb-1">Nutrition</h5>

                            </div>
                            <i class="fa fa-plus" data-bs-toggle="modal" data-bs-target="#modal-resp"></i>
                            <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        </div>
                        <div id="chart-2"></div>
                    </div>
                    <!-- END card-body -->
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100 mt-2">
                    <!-- BEGIN card-body -->
                    <div class="card-body">
                        <div class="d-flex mb-3 gap-1">
                            <div class="flex-grow-1">
                                <h5 class="mb-1">Renal Assessment</h5>

                            </div>
                            <i class="fa fa-plus" data-bs-toggle="modal" data-bs-target="#modal-resp"></i>
                            <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        </div>
                        <div id="chart-2"></div>
                    </div>
                    <!-- END card-body -->
                </div>
            </div>


        </div>

    </div>
    @include('recording.cardio-assessment')
    {{-- Modal Respiratory --}}
    @include('recording.respiratory-assessment')
    @include('recording.neuro-assessment')
    @include('recording.fluid-balance')
    @include('recording.invasive-line')
    @include('recording.lab-result')
    @include('recording.renal')
    @include('recording.skin')
    @include('recording.daily-note')
    @include('recording.medication')
    @include('recording.nutrition')
    @include('recording.physician-order')
    @include('recording.progress')


    {{-- <div class="block block-themed block-transparent mb-0">
        <div class="block-header bg-secondary-dark">
            <h3 class="block-title">Fluid Intake / Output Record</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-fw fa-times"></i>
                </button>
            </div>
        </div>
        <div class="block-content font-size-sm">

            <h3 class="text-center text-uppercase">Record Fluid Intake / Output</h3>
            <div class="bg-modern-lighter border rounded p-2">
                <form action="{{ route('fluidreport.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="inpatient_id" value="{{ $inpatient->id }}">
                    <div class="form-row" id="scroll-fluid">
                        <div class="form-group col-md-6">
                            <label for="select-fluid">Select Fluid</label>
                            <select class="js-select2 form-control form-control-lg" id="select-fluid" name="fluid_select"
                                style="width: 100%;" data-placeholder="Choose one..">
                                <option></option>
                                <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                @foreach ($inpatient->fluidReports as $item)
                                    <option value="{{ $item->id }}"> {{ $item->fluid }}</option>
                                @endforeach
                                <option value="others">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row" id="new-fluid">
                        <div class="form-group col-md-6">
                            <label for="fluid_name">Fluid name</label>
                            <input type="text" name="fluid_name" id="fluid_name"
                                class="form-control form-control-lg">

                        </div>
                        <div class="form-group col-md-6">
                            <label for="direction"> Direction</label>
                            <select name="direction" id="direction" class="form-control form-control-lg">
                                <option value="input">Intake</option>
                                <option value="output">Output</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="amount">Volume</label>
                            <input type="number" name="measure" class="form-control form-control-lg" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="datetimepicker4">DAte time</label>
                            <div class='input-group date' id='datetimepicker4'>
                                <input type='text' class="form-control" name="date_done" />
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </div>
                        </div>

                    </div>
                    <div class="form-row">
                        <button type="submit" class="btn btn-lg btn-outline-success">Save</button>
                    </div>
                </form>
            </div>


        </div>
        <div class="block-content block-content-full text-right border-top">
            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal"><i
                    class="fa fa-check mr-1"></i>Ok</button>
        </div>
    </div> --}}

@endsection
