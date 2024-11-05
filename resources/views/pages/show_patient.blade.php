@extends('layout.empty')

@section('title', 'patient_details')

@push('css')
    <link href="{{ asset('assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet">

    <!-- required js / css -->
    <link href="{{ asset('assets/plugins/select-picker/dist/picker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/summernote/dist/summernote-lite.css') }}" rel="stylesheet">
@endpush

@push('js')
    <script src="{{ asset('assets/plugins/summernote/dist/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select-picker/dist/picker.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('.summernote').summernote({
                height: 300,

            });
            $('.datepicker-across').datepicker({
                autoclose: true,
                todayHighlight: true,
                todayBtn: true
            });
            let activeDay = $('#active-day').val();
            $('.searchPicker').picker({
                search: true
            });

            $('.timepickerAcross').timepicker({
                defaultTime: 'current',
                showMeridian: false,
                minuteStep: 1
            });
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

            function getFluidSelect() {
                $.ajax({
                    type: 'GET',
                    url: '{{ route('fluid.get', $patient->latestPatientCare->id) }}',
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        $("#select-fluid").empty().append(
                            '<option value="others">Add New Fluid</option><option value="" selected>Select an option</option>'
                        );

                        // Populate with new options
                        $.each(data.data, function(index, option) {
                            $("#select-fluid").prepend('<option value="' + option.fluid + '">' +
                                option.fluid + '</option>');
                        });
                    }
                });
            }

            function getMedicationSelect() {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('medication.get', $patient->latestPatientCare->id) }}",
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        $("#select-medication").empty().append(
                            '<option value="others">Add New Medication</option><option value="" selected>Select an option</option>'
                        );
                        $.each(data, function(index, option) {
                            $("#select-medication").prepend('<option value="' + option
                                .medication + '">' + option.medication + '</option>');
                        });

                    }
                });
            }

            function getNutritionSelect() {
                $.ajax({
                    type: 'GET',
                    url: "{{ route('nutrition.get', $patient->latestPatientCare->id) }}",
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        $("#select-nutrition").empty().append(
                            '<option value="others">Add New Nutrition</option><option value="" selected>Select an option</option>'
                        );
                        $.each(data, function(index, option) {
                            $("#select-nutrition").prepend('<option value="' + option
                                .feeding_route + '">' + option.feeding_route + '</option>');
                        });
                    }
                });
            }

            getFluidSelect();
            getMedicationSelect();
            getNutritionSelect();

            function getFluidData() {
                $.ajax({
                    type: 'GET',
                    url: `{{ URL::to('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/fluid-assessment/${activeDay}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        let fluidData = data.data;
                        // console.log(myData);
                        // console.log()
                        var table = $('<table class="table table-bordered"></table>');
                        var headerIndicator = $('<thead></thead>');
                        // Create a table header row
                        var headerRow = $('<tr></tr>');
                        headerRow.append('<th class="bg-yellow-300">label</th>');
                        for (var i = 0; i < fluidData.label.length; i++) {

                            headerRow.append('<th>' + fluidData.label[i] + '</th>');
                        }
                        headerIndicator.append(headerRow);
                        table.append(headerIndicator);

                        // Create table body rows
                        for (var key in fluidData) {
                            if (key !== "label" && key !== 'Direction') {
                                var row = $('<tr></tr>');
                                row.append('<th class="bg-yellow-300 ps-1">' + key + '</th>');
                                for (var i = 0; i < fluidData[key].length; i++) {

                                    row.append('<td>' + fluidData[key][i] + '</td>');
                                }
                                table.append(row);
                            }
                        }
                        $('#table-fluid').html(table);
                    },
                    error: function(error) {
                        // Handle errors
                        console.error(error);
                        // You can display an error message to the user here
                    }
                });
            }
            // Store the GET function in a variable
            function getCardioData() {
                $.ajax({
                    type: 'GET', // or 'POST' if required
                    url: `{{ URL::to('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/cardio-assessment/${activeDay}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {


                        // $('#chart-3').html(data.data);
                        let myData = data.data;
                        // console.log(myData);
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
                                row.append('<th class="bg-yellow-300 ps-1">' + key + '</th>');
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

            function getRespData() {
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
                        headerRow.append('<th class="bg-dark-300 text-light">label</th>');
                        for (var i = 0; i < respData.label.length; i++) {

                            headerRow.append('<th>' + respData.label[i] + '</th>');
                        }
                        headerIndicator.append(headerRow);
                        table.append(headerIndicator);

                        // Create table body rows
                        for (var key in respData) {
                            if (key !== "label") {
                                var row = $('<tr></tr>');
                                row.append('<th class="bg-dark-300 ps-2 text-white">' + key + '</th>');
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

            function getMedicationData() {
                $.ajax({
                    type: 'GET', // or 'POST' if required
                    url: `{{ URL::to('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/medication/${activeDay}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        // $('#chart-3').html(data.data);
                        let medicationData = data.data;
                        var table = $('<table class="table table-bordered"></table>');
                        var headerIndicator = $('<thead></thead>');
                        // Create a table header row
                        var headerRow = $('<tr></tr>');
                        headerRow.append('<th class="bg-dark-300 text-light">label</th>');
                        for (var i = 0; i < medicationData.label.length; i++) {

                            headerRow.append('<th>' + medicationData.label[i] + '</th>');
                        }
                        headerIndicator.append(headerRow);
                        table.append(headerIndicator);

                        // Create table body rows
                        for (var key in medicationData) {
                            if (key !== "label") {
                                var row = $('<tr></tr>');
                                row.append('<th class="bg-dark-300 ps-2 text-white">' + key + '</th>');
                                for (var i = 0; i < medicationData[key].length; i++) {

                                    row.append('<td class="text-center">' + medicationData[key][i] +
                                        '</td>');
                                }
                                table.append(row);
                            }
                        }
                        $("#table-medication").html(table);

                    },
                    error: function(error) {
                        // Handle errors
                        console.error(error);
                    }
                });

            }

            function getNutritionData() {
                $.ajax({
                    type: 'GET', // or 'POST' if required
                    url: `{{ URL::to('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/nutritions/${activeDay}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        // $('#chart-3').html(data.data);
                        let nutritionData = data.data;
                        var table = $('<table class="table table-bordered"></table>');
                        var headerIndicator = $('<thead></thead>');
                        // Create a table header row
                        var headerRow = $('<tr></tr>');
                        headerRow.append('<th class="bg-dark-300 text-light">label</th>');
                        for (var i = 0; i < nutritionData.label.length; i++) {

                            headerRow.append('<th>' + nutritionData.label[i] + '</th>');
                        }
                        headerIndicator.append(headerRow);
                        table.append(headerIndicator);

                        // Create table body rows
                        for (var key in nutritionData) {
                            if (key !== "label") {
                                var row = $('<tr></tr>');
                                row.append('<th class="ps-2">' + key + '</th>');
                                for (var i = 0; i < nutritionData[key].length; i++) {

                                    row.append('<td class="text-center">' + nutritionData[key][i] +
                                        '</td>');
                                }
                                table.append(row);
                            }
                        }
                        $("#table-nutrition").html(table);

                    },
                    error: function(error) {
                        // Handle errors
                        console.error(error);
                    }
                });

            }

            function getNeuroData() {
                $.ajax({
                    type: 'GET', // or 'POST' if required
                    url: `{{ URL::to('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/neuro-assessment/${activeDay}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {

                        let neuroData = data;

                        if ($.isEmptyObject(neuroData)) {
                            $("#neuro-chart").html('<h2 class="text-center">No data</h2>');

                        } else {
                            var table = $('<table class="table table-bordered"></table>');
                            var headerIndicator = $('<thead></thead>');
                            // Create a table header row
                            var headerRow = $('<tr></tr>');
                            headerRow.append('<th class="bg-danger-300">label</th>');
                            for (var i = 0; i < neuroData.hour_taken.length; i++) {

                                headerRow.append('<th>' + neuroData.hour_taken[i] + '</th>');
                            }
                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);
                            for (var key in neuroData) {
                                if (key !== "hour_taken") {
                                    var row = $('<tr></tr>');
                                    row.append('<th class="bg-danger text-white ps-1">' + key +
                                        '</th>');
                                    for (var i = 0; i < neuroData[key].length; i++) {

                                        row.append('<td class="ps-3">' + neuroData[key][i] + '</td>');
                                    }
                                    table.append(row);
                                }
                            }

                            $("#neuro-chart").html(table);
                        }
                    },
                    error: function(error) {
                        // Handle errors
                        console.error(error);
                    }
                })
            }

            function getLabData() {
                $.ajax({
                    type: 'GET', // or 'POST' if required
                    url: `{{ URL::to('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/lab-test/${activeDay}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        // $('#chart-3').html(data.data);
                        let labData = data
                        console.log(labData);
                        if ($.isEmptyObject(labData)) {
                            $("#table-lab").html('<h2 class="text-center">No data</h2>');
                        } else {
                            var table = $(
                                '<table class="table table-bordered" id="form-table-lab"></table>');
                            var headerIndicator = $('<thead></thead>');
                            // Create a table header row
                            var headerRow = $('<tr></tr>');
                            headerRow.append(`<th class="bg-dark-300 text-light">Test Name</th>
                    <th class="bg-dark-300 text-light">Sent</th>
                    <th class="bg-dark-300 text-light">Collected</th>
                    <th class="bg-dark-300 text-light">Action</th>`);


                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);

                            // Create table body rows
                            $.each(labData, function(key, value) {
                                let actionButton = (value.result_received == 0) ?
                                    '<button type="button" data-id="' + value.id +
                                    '"data-name="' + value.lab_test +
                                    '" class="result btn btn-primary btn-sm">Mark test as received</button>' :
                                    '<i class="fas fa-check text-success"></i>';
                                let result_received = (value.result_received == 1) ?
                                    '<i class="fas fa-check text-success"></i>' :
                                    '<i class="fas fa-times text-danger"></i>';
                                var row = $('<tr></tr>');
                                row.append(`<th class="ps-2">${value.lab_test}</th>
                        <td class="text-center"><i class="fas fa-check text-success proba"></i></td>
                        <td class="text-center">${result_received}</td>
                        <td class="text-center p-1">${actionButton} </td>`);
                                table.append(row);
                            });


                            $("#table-lab").html(table);
                        }

                    },
                    error: function(error) {
                        // Handle errors
                        console.error(error);
                    }
                });


            }

            function getSkinData() {
                $.ajax({
                    type: 'GET', // or 'POST' if required
                    url: `{{ URL::to('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/skin-test/${activeDay}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        // $('#chart-3').html(data.data);
                        let skinData = data
                        console.log(skinData);
                        if ($.isEmptyObject(skinData)) {
                            $("#table-skin").html('<h2 class="text-center">No SKin data</h2>');
                        } else {
                            var table = $('<table class="table table-bordered"></table>');
                            var headerIndicator = $('<thead></thead>');
                            // Create a table header row
                            var headerRow = $('<tr></tr>');
                            headerRow.append('<th class="bg-dark-300 text-light">Test Name</th>');
                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);
                            $.each(skinData, function(key, value) {
                                var row = $('<tr></tr>');
                                row.append('<th class="ps-2">' + value + '</th>');
                                table.append(row);
                            });
                            $("#table-skin").html(table);
                        }
                    },
                    error: function(error) {
                        // Handle errors
                        console.error(error);
                    }
                });

            }

            function getSeizureData() {
                $.ajax({
                    type: 'GET', // or 'POST' if required
                    url: '{{ route('seizure.show', $patient->latestPatientCare->id) }}',
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {

                        let seizureData = data;
                        console.log(seizureData);
                        if ($.isEmptyObject(seizureData)) {
                            $('#table-seizure').html(
                                '<h2 class="text-center">No Seizure Recorded.</h2>');
                        } else {
                            var table = $('<table class="table table-bordered"></table>');
                            var headerIndicator = $('<thead></thead>');
                            // Create a table header row
                            var headerRow = $('<tr class="bg-warning-600"></tr>');
                            headerRow.append(`<th>Date</th>
                      <th>Time</th><th>Description</th><th>Duration</th><th>Intervention</th>`);
                            table.append(headerRow);
                            $.each(seizureData, function(key, value) {
                                table.append(`<tr>
                                <td class="text-center px-1">${value.new_date}</td>
                                <td class="text-center px-1">${value.time}</td>
                                <td class="text-center px-1">${value.description}</td>
                                <td class="text-center px-1">${value.durations}</td>
                                <td class="text-center px-1">${value.intervention}`);
                            });
                            $('#table-seizure').html(table)
                        }
                    },
                    error: function(error) {
                        // Handle errors
                        console.error(error);
                    }

                });
            }
            function getDailyData() {
                $.ajax({
                    type: 'GET', // or 'POST' if required
                    url: `{{url('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/dailynotes/${activeDay}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        // $('#chart-3').html(data.data);
                        let dailyData = data
                        console.log(dailyData);
                        if ($.isEmptyObject(dailyData)) {
                            $("#table-daily").html(
                                '<h2 class="text-center">No Daily Notes Recorded</h2>');
                        } else {
                            var table = $(
                                '<table class="table table-bordered" id="form-table-daily"></table>'
                            );
                            var headerIndicator = $('<thead></thead>');
                            // Create a table header row
                            var headerRow = $('<tr></tr>');
                            headerRow.append(`<th class="bg-dark-300 text-light">Daily Notes</th>
                    <th class="bg-dark-300 text-light">Date Inserted</th>
                   `);
                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);
                            $.each(dailyData, function(key, value) {
                                var row = $('<tr></tr>');
                                row.append(`<td>${value}</td>
                                <td>${key}</td>
                                `);
                                table.append(row);
                            });
                            $("#table-daily").html(table);
                        }
                    },
                    error: function(error) {
                        // Handle errors
                        console.error(error);
                    }

                })
            }

            function getInvasiveData() {
                $.ajax({
                    type: 'GET', // or 'POST' if required
                    url: `{{ route('invasive.show', $patient->latestPatientCare->id) }}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        // $('#chart-3').html(data.data);
                        let invasiveData = data
                        console.log(invasiveData);
                        if ($.isEmptyObject(invasiveData)) {
                            $("#table-invasive").html(
                                '<h2 class="text-center">No Invasive Line recorded</h2>');
                        } else {
                            var table = $(
                                '<table class="table table-bordered" id="form-table-invasive"></table>'
                            );
                            var headerIndicator = $('<thead></thead>');
                            // Create a table header row
                            var headerRow = $('<tr></tr>');
                            headerRow.append(`<th class="bg-dark-300 text-light">Invasive Line</th>
                    <th class="bg-dark-300 text-light">Date Inserted</th>
                   `);
                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);
                            $.each(invasiveData, function(key, value) {
                                var row = $('<tr></tr>');
                                row.append(`<th class="ps-2">${value.invasive_lines}</th>
                    <td class="text-center">${value.new_date}</td>
                   `);
                                table.append(row);
                            });
                            $("#table-invasive").html(table);
                        }
                    },
                    error: function(error) {
                        // Handle errors
                        console.error(error);
                    }

                });
            }
            function getRenalData(){
                $.ajaxa({
                    type: 'GET', // or 'POST' if required
                    url: `{{url('/')}}/show-patient/{{ $patient->latestPatientCare->id }}/renal/${activeDay}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        // $('#chart-3').html(data.data);
                        let renalData = data
                        console.log(renalData);
                        if ($.isEmptyObject(renalData)) {
                            $("#table-renal").html(
                                '<h2 class="text-center">No Renal Notes Recorded</h2>');
                        } else {
                            var table = $(
                                '<table class="table table-bordered" id="form-table-renal"></table>'
                            );
                            var headerIndicator = $('<thead></thead>');
                            // Create a table header row
                            var headerRow = $('<tr></tr>');
                            headerRow.append(`<th class="bg-dark-300 text-light">Renal Notes</th>
                    <th class="bg-dark-300 text-light">Date Inserted</th>
                   `);
                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);
                            $.each(renalData, function(key, value) {
                                var row = $('<tr></tr>');
                                row.append(`<td>${value}</td>
                                <td>${key}</td>
                                `);
                                table.append(row);
                            });
                            $("#table-renal").html(table);
                        }
                    },
                    error: function(error) {
                        // Handle errors
                        console.error(error);
                    }
                    
                    })
            }
            getCardioData();
            getRespData();
            getFluidData();
            getMedicationData();
            getNutritionData();
            getNeuroData();
            getLabData();
            getSeizureData();
            getInvasiveData();
            getDailyData();
            getRenalData();
            $(document).on('click', '.result', function() {
                let id = $(this).data('id');

                $('#collectResult').val(id);

                $('#collectResultLabel').append('Mark <span class="text-danger fw-bolder">' + $(this).data(
                    'name') + '</span> as received');
                $('#modal-result').modal('show');
            })
            $('#collect-result-save-spinner').hide();
            $('#collect-result-form').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var formData = $(this).serialize(); // Serialize form data
                $('#collect-result-save').prop('disabled', true);
                $('#collect-result-save-spinner').show();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('collect-result.store') }}', // Replace with your server-side script URL
                    data: formData,
                    success: function(response) {

                        console.log(response);
                        $('#toast-1 .toast-body').html(response.message);
                        $('#toast-1').toast('show');
                        $('#modal-result').modal('hide');

                        $('#collect-result-form')[0].reset();
                        $('#collect-result-save').prop('disabled', false);
                        $('#collect-result-save-spinner').hide();
                        getLabData();
                    },
                    error: function(error) {
                        // Handle errors$
                        console.error(error);
                        // You can display an error message to the user here
                        var errorMessage = error.responseJSON.message;
                        $.each(errorMessage, function(key, value) {
                            $('#collect-result-form .alert-danger').append('<p>' +
                                value + '</p>');
                        })

                        $('#collect-result-save').prop('disabled', false);
                        $('#collect-result-save-spinner').hide();
                    }
                });
            });
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
            $('#new-fluid').hide();
            $('#new-medication').hide();
            $('#select-medication').on('change', function() {
                var selectVal = $(this).val();
                console.log(selectVal);
                if ($(this).val() == 'others') {
                    $('#new-medication').show();
                } else {
                    $('#new-medication').hide();
                }
            });
            $('#new-nutrition').hide();
            $('#select-nutrition').on('change', function() {
                var selectVal = $(this).val();
                console.log(selectVal);
                if ($(this).val() == 'others') {
                    $('#new-nutrition').show();
                } else {
                    $('#new-mutrition').hide();
                }
            });
            $('#select-fluid').on('change', function() {
                var selectVal = $(this).val();
                console.log(selectVal);
                if ($(this).val() == 'others') {
                    $('#new-fluid').show();
                } else {
                    $('#new-fluid').hide();
                }
            });

            $('#new-lab').hide();
            $('#defaultothers').on('change', function() {
                var selectVal = $(this).val();
                if ($(this).is(':checked')) {
                    // Checkbox is checked
                    $('#new-lab').show();

                } else {

                    $('#new-lab').hide();
                }
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
                        $('#modal-resp').modal('hide');

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
            //invasive line form
            $('#invasive-save-spinner').hide();
            $('#invasive-form').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var invasiveData = $(this).serialize(); // Serialize form data

                $('#invasive-save').prop('disabled', true);
                $('#invasive-save-spinner').show();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('invasive.store') }}', // Replace with your server-side script URL
                    data: invasiveData,
                    success: function(response) {

                        console.log(response);
                        $('#toast-1 .toast-body').html(response.message);
                        $('#toast-1').toast('show');
                        $('#modal-invasive').modal('hide');

                        $('#invasive-form')[0].reset();
                        $('#invasive-save').prop('disabled', false);
                        $('#invasive-save-spinner').hide();
                        getInvasiveData();
                    },
                    error: function(error) {
                        // Handle errors$
                        console.error(error);
                        // You can display an error message to the user here
                        var errorMessage = error.responseJSON.message;
                        $.each(error.responseJSON.errors, function(key, value) {
                            $('#invasive-form').append(
                                '<div class="alert alert-danger">' +
                                value + '</div>');
                        });

                        $('#invasive-save').prop('disabled', false);
                        $('#invasive-save-spinner').hide();
                    }
                });

            });
            //fluid-balance form
            $('#fluid-save-spinner').hide();
            $('#fluid-form').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var fluidData = $(this).serialize(); // Serialize form data

                $('#fluid-save').prop('disabled', true);
                $('#fluid-save-spinner').show();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('fluid.store') }}', // Replace with your server-side script URL
                    data: fluidData,
                    success: function(response) {

                        console.log(response);
                        $('#toast-1 .toast-body').html(response.message);
                        $('#toast-1').toast('show');
                        $('#modal-fluid').modal('hide');

                        $('#fluid-form')[0].reset();
                        $('#fluid-save').prop('disabled', false);
                        $('#fluid-save-spinner').hide();
                        $('#new-fluid').hide();
                        getFluidData();
                        getMedicationSelect();
                    },
                    error: function(error) {
                        // Handle errors$
                        console.error(error);
                        // You can display an error message to the user here
                        var errorMessage = error.responseJSON.message;
                        $('#toast-1 .toast-body').html(errorMessage);
                        $('#toast-1').toast('show');
                        $('#fluid-save').prop('disabled', false);
                        $('#fluid-save-spinner').hide();

                    }
                });
            });
            //medication form
            $('#medication-save-spinner').hide();
            $('#medication-form').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var medicationData = $(this).serialize(); // Serialize form data

                $('#medication-save').prop('disabled', true);
                $('#medication-save-spinner').show();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('medication.store') }}', // Replace with your server-side script URL
                    data: medicationData,
                    success: function(response) {

                        console.log(response);
                        $('#toast-1 .toast-body').html(response.message);
                        $('#toast-1').toast('show');
                        $('#modal-medication').modal('hide');

                        $('#medication-form')[0].reset();
                        $('#medication-save').prop('disabled', false);
                        $('#medication-save-spinner').hide();
                        getMedicationData();
                        getMedicationSelect();

                    },
                    error: function(error) {
                        // Handle errors$
                        console.error(error);
                        // You can display an error message to the user here
                        var errorMessage = error.responseJSON.message;
                        $('#toast-1 .toast-body').html(errorMessage);
                        $('#toast-1').toast('show');
                        $('#medication-save').prop('disabled', false);
                        $('#medication-save-spinner').hide();

                    }
                });

            });
            //nutrition form
            $('#nutrition-save-spinner').hide();
            $('#nutrition-form').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var nutritionData = $(this).serialize(); // Serialize form data

                $('#nutrition-save').prop('disabled', true);
                $('#nutrition-save-spinner').show();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('nutrition.store') }}', // Replace with your server-side script URL
                    data: nutritionData,
                    success: function(response) {

                        console.log(response);
                        $('#toast-1 .toast-body').html(response.message);
                        $('#toast-1').toast('show');
                        $('#modal-nutrition').modal('hide');

                        $('#nutrition-form')[0].reset();
                        $('#nutrition-save').prop('disabled', false);
                        $('#nutrition-save-spinner').hide();
                        getNutritionData();
                        getNutritionSelect();

                    },
                    error: function(error) {
                        // Handle errors$
                        console.error(error);
                        // You can display an error message to the user here
                        var errorMessage = error.responseJSON.message;
                        $('#toast-1 .toast-body').html(errorMessage);
                        $('#toast-1').toast('show');
                        $('#nutrition-save').prop('disabled', false);
                        $('#nutrition-save-spinner').hide();
                    }
                });

            });
            //neuro form
            $('#neuro-save-spinner').hide();
            $('#neuro-form').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var neuroData = $(this).serialize(); // Serialize form data

                $('#neuro-save').prop('disabled', true);
                $('#neuro-save-spinner').show();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('neuro.store') }}', // Replace with your server-side script URL
                    data: neuroData,
                    success: function(response) {

                        console.log(response);
                        $('#toast-1 .toast-body').html(response.message);
                        $('#toast-1').toast('show');
                        $('#modal-neuro').modal('hide');
                        $('#neuro-form')[0].reset();
                        $('#neuro-save').prop('disabled', false);
                        $('#neuro-save-spinner').hide();
                        getNeuroData();

                    },
                    error: function(error) {
                        // Handle errors$
                        console.error(error);
                        // You can display an error message to the user here
                        var errorMessage = error.responseJSON.message;
                        $('#toast-1 .toast-body').html(errorMessage);
                        $('#toast-1').toast('show');
                        $('#neuro-save').prop('disabled', false);
                        $('#neuro-save-spinner').hide();
                    }
                });

            });
            //seizure form
            $('#seizure-save-spinner').hide();
            $('#seizure-form').submit(function(event) {
                event.preventDefault();
                var seizureData = $(this).serialize();
                $('#seizure-save').prop('disabled', true);
                $('#seizure-save-spinner').show();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('seizure.store') }}',
                    data: seizureData,
                    success: function(response) {

                        console.log(response);
                        $('#toast-1 .toast-body').html(response.message);
                        $('#toast-1').toast('show');
                        $('#modal-seizure').modal('hide');
                        $('#seizure-form')[0].reset();
                        $('#seizure-save').prop('disabled', false);
                        $('#seizure-save-spinner').hide();
                        getSeizureData();
                    },
                    error: function(error) {
                        // Handle errors$
                        $.each(error.responseJSON.errors, function(key, value) {
                            $('#seizure-form').append('<div class="text-danger">' +
                                value + '</div>');
                        });
                        $('#seizure-save').prop('disabled', false);
                        $('#seizure-save-spinner').hide();
                    }

                })
            });
            //daily note form
            $('#daily-save-spinner').hide();
            $('#daily-form').submit(function(event) {
                event.preventDefault();
                var dailyData = $(this).serialize();
                $('#daily-save').prop('disabled', true);
                $('#daily-save-spinner').show();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('dailynotes.store') }}',
                    data: dailyData,
                    success: function(response) {

                        console.log(response);
                        $('#toast-1 .toast-body').html(response.message);
                        $('#toast-1').toast('show');
                        $('#modal-daily').modal('hide');
                        $('#daily-form')[0].reset();
                        $('#daily-save').prop('disabled', false);
                        $('#daily-save-spinner').hide();
                        getDailyData();
                    },
                    error: function(error) {
                        // Handle errors$
                        $.each(error.responseJSON.errors, function(key, value) {
                            $('#daily-form').append('<div class="text-danger">' +
                                value + '</div>');
                        });
                        $('#daily-save').prop('disabled', false);
                        $('#daily-save-spinner').hide();
                    }
                });
            })
            //skin form wire:abort

            //skin form
            $('#skin-save-spinner').hide();
            $('#skin-form').submit(function(event) {
                event.preventDefault();
                var skinData = $(this).serialize();
                $('#skin-save').prop('disabled', true);
                $('#skin-save-spinner').show();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('skin.store') }}',
                    data: skinData,
                    success: function(response) {

                        console.log(response);
                        $('#toast-1 .toast-body').html(response.message);
                        $('#toast-1').toast('show');
                        $('#modal-skin').modal('hide');
                        $('#skin-form')[0].reset();
                        $('#skin-save').prop('disabled', false);
                        $('#skin-save-spinner').hide();
                        getSkinData();
                    },
                    error: function(error) {
                        // Handle errors$
                        $.each(error.responseJSON.errors, function(key, value) {
                            $('#skin-form').append('<div class="text-danger">' +
                                value + '</div>');
                        });
                        $('#skin-save').prop('disabled', false);
                        $('#skin-save-spinner').hide();
                    }
                })
            });

            //lab form
            $('#lab-save-spinner').hide();
            $('#lab-form').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var labData = $(this).serialize(); // Serialize form data

                $('#lab-save').prop('disabled', true);
                $('#lab-save-spinner').show();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('lab.store') }}', // Replace with your server-side script URL
                    data: labData,
                    success: function(response) {

                        console.log(response);
                        $('#toast-1 .toast-body').html(response.message);
                        $('#toast-1').toast('show');
                        $('#modal-lab').modal('hide');
                        $('#lab-form')[0].reset();
                        $('#lab-save').prop('disabled', false);
                        $('#lab-save-spinner').hide();
                        getLabData();

                    },
                    error: function(error) {
                        // Handle errors$
                        console.error(error);
                        $('#lab-save').prop('disabled', false);
                        $('#lab-save-spinner').hide();
                        // You can display an error message to the user here
                        $.each(error.responseJSON.errors, function(field, messages) {
                            $.each(messages, function(i, message) {
                                $('#lab-form .alert-danger').append('<p>' +
                                    message + '</p>');
                            });
                        })


                    }
                });
            });
            //
            $('#pupil-diameter').on('change', function() {
                $('#value-pupil-diameter').html(this.value);
            })
            $('#active-day').on('change', function() {
                activeDay = $('#active-day').val();
                getCardioData();
                getRespData();
                getFluidData();
                getMedicationData();
                getNutritionData();
                getNeuroData();
                getLabData();
                getInvasiveData();
                getDailyData();
                getRenalData();
            });
        });
    </script>
@endpush

@section('content')
    <div class="toast-container sticky-top">
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
        <div class="card border-theme border-3 sticky-md-top">
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
            <div class="col-lg-6" id="resp-card">
                <div class="card h-100 mt-2">
                    <div class="card-header  bg-dark d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-1 text-white">Respiratory Assessment</h5>
                        </div>
                        <div class="d-flex gap-2 align-items-center">

                            <i class="fa fa-plus text-white" data-bs-toggle="modal" data-bs-target="#modal-resp"></i>
                            <a href="javascript:;" class="text-secondary"><i
                                    class="fa fa-redo"></i></a>
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
            <div class="col-lg-6" id="fluid-card">
                <div class="card h-100 mt-2">
                    <!-- BEGIN card-body -->
                    <div class="card-header bg-warning d-flex gap-2 align-items-center">

                        <div class="flex-grow-1">
                            <h5 class="mb-1">Fluid Balance</h5>

                        </div>
                        <i class="fa fa-plus" data-bs-toggle="modal" data-bs-target="#modal-fluid"></i>
                        <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        <a href="#" data-toggle="card-expand"
                            class="text-white text-opacity-20 text-decoration-none"><i class="fa fa-fw fa-expand"></i></a>

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
                    <div id="neuroChart"></div>
                    <!-- BEGIN card-body -->
                    <div class="card-header bg-danger d-flex gap-2 align-items-center">

                        <div class="flex-grow-1">
                            <h5 class="mb-1">Neurological Assessment</h5>

                        </div>
                        <i class="fa fa-plus" data-bs-toggle="modal" data-bs-target="#modal-neuro"></i>
                        <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        <a href="#" data-toggle="card-expand"
                            class="text-white text-opacity-20 text-decoration-none"><i class="fa fa-fw fa-expand"></i></a>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="neuro-chart"></div>



                    </div>
                    <!-- END card-body -->
                </div>
            </div>
            <div class="col-lg-6" id="med-card">
                <div class="card h-100 mt-2">
                    <!-- BEGIN card-body -->
                    <div class="card-header bg-gradient bg-warning-400 d-flex gap-2 align-items-center">

                        <div class="flex-grow-1">
                            <h5 class="mb-1">Medications</h5>

                        </div>
                        <i class="fa fa-plus" data-bs-toggle="modal" data-bs-target="#modal-medication"></i>
                        <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        <a href="#" data-toggle="card-expand"
                            class="text-white text-opacity-20 text-decoration-none"><i class="fa fa-fw fa-expand"></i></a>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="table-medication">

                        </div>


                    </div>
                    <!-- END card-body -->
                </div>
            </div>
            <div class="col-lg-6" id="lab-card">
                <div class="card h-100 mt-2">
                    <!-- BEGIN card-body -->
                    <div class="card-header bg-gradient bg-gray-400 d-flex gap-2 align-items-center">

                        <div class="flex-grow-1">
                            <h5 class="mb-1">Investigations</h5>

                        </div>
                        <i class="fa fa-plus" data-bs-toggle="modal" data-bs-target="#modal-lab"></i>
                        <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        <a href="#" data-toggle="card-expand"
                            class="text-white text-opacity-20 text-decoration-none"><i class="fa fa-fw fa-expand"></i></a>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="table-lab">

                        </div>


                    </div>
                    <!-- END card-body -->
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100 mt-2">
                    <!-- BEGIN card-body -->
                    <div class="card-header bg-gradient bg-teal-400 d-flex gap-2 align-items-center">

                        <div class="flex-grow-1">
                            <h5 class="mb-1">Nutrition</h5>

                        </div>
                        <i class="fa fa-plus" data-bs-toggle="modal" data-bs-target="#modal-nutrition"></i>
                        <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        <a href="#" data-toggle="card-expand"
                            class="text-white text-opacity-20 text-decoration-none"><i class="fa fa-fw fa-expand"></i></a>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="table-nutrition">

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
                                <h5 class="mb-1">Renal Assessment</h5>

                            </div>
                            <i class="fa fa-plus" data-bs-toggle="modal" data-bs-target="#modal-resp"></i>
                            <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        </div>
                        <div id="table-renal" class="table-responsive"></div>
                    </div>
                    <!-- END card-body -->
                </div>
            </div>
            <div class="col-lg-6" id="skin">
                <div class="card h-100 mt-2">
                    <!-- BEGIN card-body -->
                    <div class="card-header bg-gradient bg-purple d-flex gap-2 align-items-center">

                        <div class="flex-grow-1">
                            <h5 class="mb-1">Skin and Wound Care</h5>

                        </div>
                        <i class="fa fa-plus" data-bs-toggle="modal" data-bs-target="#modal-skin"></i>
                        <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        <a href="#" data-toggle="card-expand"
                            class="text-white text-opacity-20 text-decoration-none"><i class="fa fa-fw fa-expand"></i></a>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="table-skin">

                        </div>


                    </div>
                    <!-- END card-body -->
                </div>
            </div>
            <div class="col-lg-6" id="invasive">
                <div class="card h-100 mt-2">
                    <!-- BEGIN card-body -->
                    <div class="card-header bg-gradient bg-dark d-flex gap-2 align-items-center">

                        <div class="flex-grow-1">
                            <h5 class="mb-1 text-white">Invasive Lines</h5>

                        </div>
                        <i class="fa fa-plus" data-bs-toggle="modal" data-bs-target="#modal-invasive"></i>
                        <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        <a href="#" data-toggle="card-expand"
                            class="text-white text-opacity-20 text-decoration-none"><i class="fa fa-fw fa-expand"></i></a>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="table-invasive">

                        </div>


                    </div>
                    <!-- END card-body -->
                </div>
            </div>
            <div class="col-lg-6" id="progress">
                <div class="card h-100 mt-2">
                    <!-- BEGIN card-body -->
                    <div class="card-header bg-gradient bg-gray-200 d-flex gap-2 align-items-center">

                        <div class="flex-grow-1">
                            <h5 class="mb-1">Progress Notes</h5>

                        </div>
                        <i class="fa fa-plus" data-bs-toggle="modal" data-bs-target="#modal-nutrition"></i>
                        <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        <a href="#" data-toggle="card-expand"
                            class="text-white text-opacity-20 text-decoration-none"><i class="fa fa-fw fa-expand"></i></a>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="table-progress">

                        </div>


                    </div>
                    <!-- END card-body -->
                </div>
            </div>
            <div class="col-lg-6" id="seizure">
                <div class="card h-100 mt-2">
                    <!-- BEGIN card-body -->
                    <div class="card-header bg-gradient bg-warning-200 d-flex gap-2 align-items-center">

                        <div class="flex-grow-1">
                            <h5 class="mb-1">Seizure Chart</h5>

                        </div>
                        <i class="fa fa-plus" data-bs-toggle="modal" data-bs-target="#modal-seizure"></i>
                        <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        <a href="#" data-toggle="card-expand"
                            class="text-white text-opacity-20 text-decoration-none"><i class="fa fa-fw fa-expand"></i></a>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="table-seizure">

                        </div>


                    </div>
                    <!-- END card-body -->
                </div>
            </div>
            <div class="col-lg-6" id="nursing">
                <div class="card h-100 mt-2">
                    <!-- BEGIN card-body -->
                    <div class="card-header bg-gradient bg-gray-100 d-flex gap-2 align-items-center">

                        <div class="flex-grow-1">
                            <h5 class="mb-1">Nursing Assessment</h5>

                        </div>
                        <i class="fa fa-plus" data-bs-toggle="modal" data-bs-target="#modal-daily"></i>
                        <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        <a href="#" data-toggle="card-expand"
                            class="text-white text-opacity-20 text-decoration-none"><i class="fa fa-fw fa-expand"></i></a>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="table-daily">

                        </div>


                    </div>
                    <!-- END card-body -->
                </div>
            </div>
            <div class="col-lg-6" id="physician">
                <div class="card h-100 mt-2">
                    <!-- BEGIN card-body -->
                    <div class="card-header bg-gradient bg-warning-500 d-flex gap-2 align-items-center">

                        <div class="flex-grow-1">
                            <h5 class="mb-1">Physician Order</h5>

                        </div>
                        <i class="fa fa-plus" data-bs-toggle="modal" data-bs-target="#modal-nutrition"></i>
                        <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        <a href="#" data-toggle="card-expand"
                            class="text-white text-opacity-20 text-decoration-none"><i class="fa fa-fw fa-expand"></i></a>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="table-seizure">

                        </div>


                    </div>
                    <!-- END card-body -->
                </div>
            </div>


        </div>

    </div>
    @include('recording.cardio-assessment')
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
    @include('recording.result-modal')
    @include('recording.seizure-chart')
    @include('recording.discharge')
@endsection
