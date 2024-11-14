@extends('layout.default', [
  'appSidebarHide' => true,
  'appClass' => 'app-content-full-width'
])

@section('title', 'patient_details')

@push('css')
    <link href="{{ asset('assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet">

    <!-- required js / css -->
    <link href="{{ asset('assets/plugins/select-picker/dist/picker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/summernote/dist/summernote-lite.css') }}" rel="stylesheet">
@endpush

@push('js')
    <script src="{{ asset('assets/plugins/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/demo/dashboard.demo.js') }}"></script>

    <script src="{{ asset('assets/plugins/summernote/dist/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select-picker/dist/picker.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            let cardioCanvas;
            $('.summernote').summernote({
                height: 200,

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

            var cardioChart= {};
             var cardioOptions = {
                chart: {
                    type: 'line',
                    height: 350,
                    toolbar: {
                        show: true
                    }
                },
                stroke: {
                    curve: 'straight'
                },
                grid: {
                    padding: {
                        right: 30,
                        left: 20
                    }
                },
                dataLabels: {
                        enabled: false
                    },
                series: [],
                title: {
                    text: 'Cardio Chart',
                },
                noData: {
                    text: 'Loading...'
                }
            }
            var cardioCharting = new ApexCharts(document.querySelector("#chartCardio"), cardioOptions);
            cardioCharting.render();

            function getFluidData() {
                $.ajax({
                    type: 'GET',
                    url: `{{ URL::to('/') }}/show-patient/{{ $patientCare->id }}/fluid-assessment/${activeDay}`,
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
                    url: `{{ URL::to('/') }}/show-patient/{{ $patientCare->id }}/cardio-assessment/${activeDay}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {

                        // $('#chart-3').html(data.data);
                        let myData = data.data;
                        // console.log(myData.label);
                        var table = $('<table class="table table-bordered"></table>');
                        var headerIndicator = $('<thead></thead>');
                        // Create a table header row
                        var headerRow = $('<tr></tr>');
                        cardioChart.label = myData.label
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
                                let newArray = [];
                                row.append('<th class="bg-yellow-300 ps-1">' + key + '</th>');
                                for (var i = 0; i < myData[key].length; i++) {
                                    row.append('<td>' + myData[key][i] + '</td>');
                                    newArray.push(~~myData[key][i]);
                                }
                                table.append(row);
                                cardioChart[key] = newArray
                            }
                        }


                        let cardioOptions = {

                            series:[
                                {
                                    name: 'Heart Rate',
                                    data: cardioChart['Heart Rate']

                                },
                                {
                                    name: 'Respiratory Rate',
                                    data: cardioChart['Respiratory Rate']
                                },
                                {
                                    name: 'Systolic Blood Pressure',
                                    data: cardioChart['Bp Systolic']
                                },
                                {
                                    name: 'Diastolic Blood Pressure',
                                    data: cardioChart['Bp Diastolic']
                                },
                                {
                                    name: 'Oxygen Saturation',
                                    data: cardioChart['Spo2']
                                },
                                {
                                    name: 'Temperature',
                                    data: cardioChart['Temperature']
                                },
                                {
                                    name: 'Peripheral Pulse',
                                    data: cardioChart['Peripheral pulses']
                                },
                                {
                                    name: 'Rhythm',
                                    data: cardioChart['Rhythm']
                                }
                            ],
                            xaxis: {
                                categories: cardioChart.label
                            },

                         };

                        cardioCharting.updateOptions(cardioOptions, true)

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
                    url: `{{ URL::to('/') }}/show-patient/{{ $patientCare->id }}/resp-assessment/${activeDay}`,
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
                        $("#table-resp-table").html(table);

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
                    url: `{{ URL::to('/') }}/show-patient/{{ $patientCare->id }}/medication/${activeDay}`,
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
                    url: `{{ URL::to('/') }}/show-patient/{{ $patientCare->id }}/nutritions/${activeDay}`,
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
                    url: `{{ URL::to('/') }}/show-patient/{{ $patientCare->id }}/neuro-assessment/${activeDay}`,
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
                    url: `{{ URL::to('/') }}/show-patient/{{ $patientCare->id }}/lab-test/${activeDay}`,
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
                    url: `{{ URL::to('/') }}/show-patient/{{ $patientCare->id }}/skin-care/${activeDay}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        // $('#chart-3').html(data.data);
                        let skinData = data
                        console.log(skinData, 'hello from skin data');
                        if ($.isEmptyObject(skinData)) {
                            $("#table-skin").html('<h2 class="text-center">No Skin Care Data</h2>');
                        } else {
                            var table = $('<table class="table table-bordered"></table>');
                            var headerIndicator = $('<thead></thead>');
                            // Create a table header row
                            var headerRow = $('<tr></tr>');
                            headerRow.append(`<th class="bg-dark-300 text-light">date</th>
                    <th class="text-center">Wound Dressings</th><th class="text-center">Drain Output</th><th>Skin Integrity</th><th>Recorded by</th>`);
                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);
                            $.each(skinData, function(key, value) {
                                var row = $('<tr class="text-center"></tr>');
                                row.append('<th class="ps-2">' + value.new_date + '</th><th>' +
                                    ((value.wound_dressings) ? value.wound_dressings : '-') + '</th><th>' + ((value.drain_output) ? value.drain_output : '-') +
                                    '</th><th>' + ((value.skin_integrity) ? value.skin_integrity : '-') + '</th><th>' + ((value.recorded_by) ? value.recorded_by : '-') +
                                    '</th>');
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
                    url: '{{ route('seizure.show', $patientCare->id) }}',
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
                    url: `{{url('/') }}/show-patient/{{ $patientCare->id }}/dailynotes/${activeDay}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        // $('#chart-3').html(data.data);
                        let dailyData = data
                        console.log(dailyData, 'hello from daily data');
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
                   `);
                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);
                            $.each(dailyData, function(key, value) {
                                var row = $(`<tr class="bg-danger-subtle text-center">
                                    <td>${value.duty_period}</td></tr>
                                    <tr>
                                        <td class="text-center">${value.daily_notes}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                          <span class="badge bg-info p-1">Recorded By: ${value.recorded_by}
                                            </span>
                                        </td>
                                    </tr>`);

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
                    url: `{{ route('invasive.show', $patientCare->id) }}`,
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
                $.ajax({
                    type: 'GET', // or 'POST' if required
                    url: `{{url('/')}}/show-patient/{{ $patientCare->id }}/renal-fluids/${activeDay}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        // $('#chart-3').html(data.data);
                        let renalData = data
                        console.log(renalData);
                        if ($.isEmptyObject(renalData)) {
                            $("#table-renal").html(
                                '<h2 class="text-center">No Renal Fluids Recorded</h2>');
                        } else {
                            var table = $(
                                '<table class="table table-bordered" id="form-table-renal"></table>'
                            );
                            var headerIndicator = $('<thead></thead>');
                            // Create a table header row
                            var headerRow = $('<tr></tr>');
                            headerRow.append(`<th class="bg-dark-300 text-light">Renal Fluid</th>
                    <th class="bg-dark-300 text-light">Total Daily volume</th>
                   `);
                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);
                            $.each(renalData, function(key, value) {
                                var row = $('<tr></tr>');
                                row.append(`<td>${key}</td>
                                <td class="text-center"> ${value}</td>
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
            function getProgressData() {
                $.ajax({
                    type: 'GET', // or 'POST' if required
                    url: `{{url('/')}}/show-patient/{{ $patientCare->id }}/daily-treatment/${activeDay}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        // $('#chart-3').html(data.data);
                        let progressData = data
                        console.log(progressData, 'Hello from progress');
                        if ($.isEmptyObject(progressData)) {
                            $("#table-progress").html(
                                '<h2 class="text-center">No Progress Notes Recorded</h2>');
                        } else {
                            var table = $(
                                '<table class="table table-bordered" id="form-table-progress"></table>'
                            );
                            var headerIndicator = $('<thead></thead>');

                            var headerRow = $(`<tr></tr>`);
                            headerRow.append(`<th class="bg-dark-300 text-light">Problems</th>
                    <th class="bg-dark-300 text-light">Intervention</th><th>Recorded By</th>
                   `);
                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);
                            $.each(progressData, function(key, value) {
                                var row = $('<tr></tr>');
                                if(value.type === "problem"){
                                    row.append(`<td class="text-center"> -- </td>
                                <td>${value.content}</td><th>${value.recorded_by}</th>
                                `);
                                }else{
                                     row.append(`<td > ${value.content} </td>
                                <td class="text-center"> -- </td><th>${value.recorded_by}</th>
                                `);
                                }

                                table.append(row);
                            });
                            $("#table-progress").html(table);
                        }
                    },
                    error: function(error) {
                        // Handle errors
                        console.error(error);
                    }

                })
            }
            function getPhysicianData() {
                $.ajax({
                    type: 'GET', // or 'POST' if required
                    url: `{{url('/')}}/show-patient/{{ $patientCare->id }}/physician-order/${activeDay}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        let physicianData = data;
                        console.log(physicianData, 'physicianData');
                        if($.isEmptyObject(physicianData)){
                            $('#table-physician').html(`<h1 class="text-center"> No Physician Note </h1>`)
                        }else{
                             var table = $(
                                '<table class="table table-bordered" id="form-table-progress"></table>'
                            );
                            var headerIndicator = $('<thead></thead>');
                            // Create a table header row
                            var headerRow = $('<tr></tr>');
                             headerRow.append(`<th class="bg-dark-300 text-light">Physician Notes</th>`);
                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);
                            $.each(physicianData, function(key, value) {
                                var row = $(`<tr>
                                    <td>
                                    ${value.content}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                           <span class="badge bg-gradient bg-info-subtle"> Recorded By: ${value.recorded_by} </span>
                                        </td>
                                    </tr>`
                                    );

                                table.append(row);
                            });
                            $("#table-physician").html(table);

                        }
                    },
                    error: function(error) {
                        // Handle errors
                        console.error(error);
                    }

                });
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
            getProgressData();
            getPhysicianData();
            getSkinData();
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




            //medication form

            //nutrition form

            //neuro form

            //seizure form


            //skin form wire:abort

            //skin form


            //lab form

            //physician form

            //progress form


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
                 getPhysicianData();
                 getProgressData();
                 getSkinData();

            });

        });
    </script>
@endpush

@section('content')


   
        <div class="card border-theme border-3 sticky-md-top" style="top:48px;">
            <div class="card-body row gx-0 align-items-center shadow-lg">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="d-flex flex-column">
                                <h4 class="mb-0"> Name: <span
                                        class=
                                    "fw-bold text-gray-emphasis">{{ $patientCare->patient->fullname }}</span>
                                </h4>
                                <h5 class="text-muted my-0 text-teal-emphasis">Age: &nbsp;
                                    {{ (int) $patientCare->patient->date_of_birth->diffInYears() }} Years
                                    {{ $patientCare->patient->date_of_birth->diffInMonths() % 12 }} Months</h5>
                                <h5 class="text-muted my-0 text-gray-emphasis">Sex: &nbsp;{{ $patientCare->patient->gender->name }}</h5>
                                <h5 class="text-muted my-0">Marital Status: &nbsp;{{ $patientCare->patient->marital_status->name }}</h5>
                            </div>
                        </div>
                        <div class="col-md-3 border-start border-2 border-primary bg-gray-200 rounded">
                            <h5 class="text-muted my-0 text-gray-emphasis">Bed-No: &nbsp;<span
                                    class="fw-bold">{{ $patientCare->bedModel->name }} </span></h5>
                            <h5 class="text-muted my-0 text-gray-emphasis">Admission-Date: &nbsp;<span
                                    class="fw-bold">{{ $patientCare->admission_date->format('d/M/Y') }}</span>
                            </h5>
                            <h5 class="text-muted my-0 text-gray-emphasis">Diagnosis: &nbsp;<span
                                    class="fw-bold">{{ $patientCare->diagnosis }}</span></h5>
                            <h5 class="text-muted my-0 text-gray-emphasis"><span class="fw-bold">Admitted-From:
                                    &nbsp;</span>{{ $patientCare->admitted_from }}</h5>
                        </div>
                        <div class="col-md-3 border-start border-2 border-primary">
                            <h5 class="text-muted my-0 text-gray-emphasis"><span class="fw-bold">Condition: &nbsp;</span>
                                {{ $patientCare->condition }}</h5>
                            <h5 class="text-muted my-0 text-gray-emphasis"><span class="fw-bold">Consultant: &nbsp;</span>
                                {{ $patientCare->icu_consultant }}
                            </h5>
                            <h5 class="text-muted my-0 text-gray-emphasis"><span class="fw-bold">Nurse Incharge:
                                    &nbsp;</span>{{ $patientCare->nurse_incharge }}</h5>
                            <h5 class="text-muted my-0 text-gray-emphasis"><span class="fw-bold">Next of Kin:
                                    &nbsp;</span>{{ $patientCare->patient->next_of_kin }}</h5>
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


                            <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                            <a href="#" data-toggle="card-expand"
                                class="text-white text-opacity-50 text-decoration-none"><i
                                    class="fa fa-fw fa-expand"></i></a>
                        </div>
                    </div>
                    <!-- BEGIN card-body -->
                    <div class="card-body">
                        
                                <div class="table-responsive" id="table-cardio">

                                </div>

                                <div id="chartCardio"></div>


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


                            <a href="javascript:;" class="text-secondary"><i
                                    class="fa fa-redo"></i></a>
                            <a href="#" data-toggle="card-expand"
                                class="text-white text-opacity-20 text-decoration-none"><i
                                    class="fa fa-fw fa-expand"></i></a>
                        </div>
                    </div>

                    <!-- BEGIN card-body -->
                    <div class="card-body">
                        
                                <div class="table-responsive" id="table-resp-table">

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
                            <h5 class="mb-1 text-white">Skin and Wound Care</h5>

                        </div>

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

                        <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        <a href="#" data-toggle="card-expand"
                            class="text-white text-opacity-20 text-decoration-none"><i class="fa fa-fw fa-expand"></i></a>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="table-physician">

                        </div>


                    </div>
                    <!-- END card-body -->
                </div>
            </div>


        </div>

   

@endsection
