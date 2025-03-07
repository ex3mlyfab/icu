@extends('layout.default', [
    'appSidebarHide' => true,
    'appClass' => 'app-content-full-width',
])

@section('title', 'patient_details')

@push('css')
    <link href="{{ asset('assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet">

    <!-- required js / css -->
    <link href="{{ asset('assets/plugins/select-picker/dist/picker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/summernote/dist/summernote-lite.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/plugins/apexcharts/dist/apexcharts.min.js') }}"></script>
    <style>
        .chart-space {
            height: 350px;
            width: 100%;
            display: none;
            /* Initially hidden */
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('assets/plugins/apexcharts/dist/apexcharts.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/summernote/dist/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select-picker/dist/picker.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            $('#patient-info-2').hide();


            $(window).scroll(function() {
                if ($(window).scrollTop() > 150) {

                    $('#patient-info').hide();
                } else {
                    $('#patient-info-2').fadeIn();
                }
            });

            $('#patient-info-full').click(function() {
                $('#patient-info').fadeIn();
                $('#patient-info-2').hide();
            });
            $('#patient-info-summary').click(function() {
                $('#patient-info-2').fadeIn();
                $('#patient-info').hide();
            });

            let viewtype = "summary";
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

            let cardioCanvas;
            let respiratoryCanvas;
            let fluidCanvas;

            function hideSelectedCards(){
                $('#nutrition-card').hide()
                $('#med-card').hide()
                $('#neuro-card').hide()
                $('#lab-card').hide()
                $('#skin-card').hide()
                $('#renal-card').hide()
                $('#invasive').hide()
                $('#progress').hide()
                $('#seizure').hide()
                $('#nursing').hide()
                $('#physician').hide()

            }
            function showSelectedCards(){
                $('#nutrition-card').show()
                $('#med-card').show()
                $('#neuro-card').show()
                $('#lab-card').show()
                $('#skin-card').show()
                $('#renal-card').show()
                $('#invasive').show()
                $('#progress').show()
                $('#seizure').show()
                $('#nursing').show()
                $('#physician').show()

            }

            function drawCardioChart() {
                $.ajax({
                    type: 'GET', // or 'POST' if required
                    url: `{{ url('/') }}/show-cardio/{{ $patient->latestPatientCare->id }}/${activeDay}/${viewtype}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        // console.log(data, 'cardio chart')
                        $("#cardio-charting").show();
                        if ($.isEmptyObject(data.data)) {
                            console.log('i am empty  - cardio chart')
                            $("#cardio-charting").html(
                                '<h2 class="text-center">No Cardio Data Found</h2>');
                        } else {


                            if (!cardioCanvas) {

                                const cardioOptionsI = {
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
                                        enabled: true,
                                    },
                                series: [],
                                title: {
                                    text: 'CardioVascular Assessment Chart',
                                },
                                noData: {
                                    text: 'Loading...'
                                }
                            }
                            var cardioCharting = new ApexCharts(document.querySelector("#cardio-charting"), cardioOptionsI);
                            cardioCharting.render();
                          }
                            let myData = data.data;
                            const cardioChart = {};
                            cardioChart.label = myData.label;
                            for (var key in myData) {
                                const newArray = [];
                                if (key !== "label") {
                                    for (var i = 0; i < myData[key].length; i++) {
                                        newArray.push(~~myData[key][i]);

                                    }

                                    cardioChart[key] = newArray
                                }
                            }
                            //  console.log(cardioChart);
                            const cardioOptions = {
                                series: [{
                                        name: 'Heart Rate',
                                        data: cardioChart['heart_rate']

                                    },
                                    {
                                        name: 'Respiratory Rate',
                                        data: cardioChart['RespiratoryRate']
                                    },
                                    {
                                        name: 'Systolic Blood Pressure',
                                        data: cardioChart['BpSystolic']
                                    },
                                    {
                                        name: 'Diastolic Blood Pressure',
                                        data: cardioChart['BpDiastolic']
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
                                        data: cardioChart['Peripheralpulses']
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
                            // console.log(cardioOptions)
                            cardioCharting.updateOptions(cardioOptions, true);
                        }
                    },
                    error: function(error) {
                        console.error("Error fetching data:", error);
                        // Handle error, e.g., display a message to the user
                        $("#cardio-charting").html(
                            "<p>Error fetching data. Please try again later.</p>");
                    }
                });


            }

            function drawFluidChart() {
                $.ajax({
                    type: 'GET',
                    url: `{{ URL::to('/') }}/fluid-chart/{{ $patient->latestPatientCare->id }}/${activeDay}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        $("#chartFluid").show();
                        if ($.isEmptyObject(data.data)) {

                            $("#chartFluid").html('<h2 class="text-center">No Fluid Data Found</h2>');

                        } else {
                            // Show the chart container
                            console.log(data)
                            if(!fluidCanvas){

                            const fluidOptionsI = {
                                chart: {
                                    type: 'line',
                                    height: 350,
                                    toolbar: {
                                        show: true
                                    }
                                },
                                grid: {
                                    padding: {
                                        right: 30,
                                        left: 20
                                    }
                                },
                                dataLabels: {
                                        enabled: true,
                                    },
                                series: [],
                                title: {
                                    text: 'Fluid Assessment Chart',
                                },                noData: {
                                    text: 'Loading...'
                                }
                            }
                            var fluidCharting = new ApexCharts(document.querySelector("#chartFluid"), fluidOptionsI);
                            fluidCharting.render();
                           }

                            let fluidData = data.data;
                            const fluidChart = {};
                            fluidChart.label = fluidData.label

                            const chartRows = {};
                            let numberOfInputRows = fluidData.label.length;
                            $.each(fluidData.fluids, function(index, value){
                                $.each(value, function(key, item) {
                                    for (let i = 0; i < numberOfInputRows; i++) {
                                            if (!chartRows[i]) {
                                                chartRows[i] = [];
                                            }
                                            if (i === index) {

                                                    chartRows[i].push(item);

                                            }
                                        }

                                })
                            })
                            console.log(chartRows, "from fluid charting", data.allFluids)
                            let fluidSeriesArray = [];
                            const fluidSeries = {};
                            $.each(data.allFluids, function(label,value){
                                fluidSeries[label]= [];
                            })
                            $.each(chartRows, function(index, value){
                                $.each(value, function(key, item){
                                    fluidSeries[key].push(item);
                                });
                            });
                            $.each(data.allFluids, function(label,value){
                               fluidSeriesArray.push({
                                name: value,
                                data:fluidSeries[label]
                               })
                            })

                           fluidCharting.updateOptions({
                            series: fluidSeriesArray,
                            xaxis:{
                                categories: fluidChart.label
                            }
                           })
                        }
                    },
                    error: function(error) {
                        console.error("Error fetching data:", error);
                        // Handle error, e.g., display a message to the user
                        $("#chartFluid").html(
                            "<p>Error fetching data. Please try again later.</p>");
                    }
                });

            }

            function drawRespChart() {
                $.ajax({
                    type: 'GET', // or 'POST' if required
                    url: `{{ URL::to('/') }}/show/{{ $patient->latestPatientCare->id }}/${activeDay}/${
                        viewtype}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        // let respData = data;
                        let myData = data.data;
                         $("#respiratory-charting").show();
                        if ($.isEmptyObject(myData)) {
                            $("#respiratory-charting").html(
                                '<h2 class="text-center">No Respiratory Data Found</h2>');
                        } else {


                            // Show the chart container
                            let respiratoryChart = {};
                            if(!respiratoryCanvas){

                            const respiratoryOptionsI = {
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
                                        enabled: true,
                                    },
                                series: [],
                                title: {
                                    text: 'Respiratory Assessment Chart',
                                },
                                noData: {
                                    text: 'Loading...'
                                }
                            }
                            var respiratoryCharting = new ApexCharts(document.querySelector("#respiratory-charting"), respiratoryOptionsI);
                            respiratoryCharting.render();
                            }
                            const respChart = {};
                            respChart.label = myData.label;
                            for (var key in myData) {
                                let newArray = [];
                                if (key !== "label") {
                                    for (var i = 0; i < myData[key].length; i++) {
                                        newArray.push(~~myData[key][i]);
                                    }
                                    respiratoryChart[key] = newArray
                                }
                            }

                            let respOptions = {
                                series: [{
                                        name: "FiO2",
                                        data: respiratoryChart["FiO2"]
                                    },
                                    {
                                        name: "Respiratory Effort",
                                        data: respiratoryChart["RespiratoryEffort"]
                                    }
                                ],
                                xaxis:{
                                categories: respiratoryChart.label
                            }
                            }
                            console.log(respiratoryChart);
                            respiratoryCharting.updateOptions(respOptions, true);

                        }
                    },
                    error: function(error) {
                        console.error("Error fetching data:", error);
                        // Handle error, e.g., display a message to the user+
                        $("#resp-charting").html("<p>Error fetching data. Please try again later.</p>");
                    }
                });
            }


            function toggleVisibility(elementId) {
                $('#' + elementId).toggle("slow");
            }


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
                            $("#select-fluid").prepend(
                                `<option value="${option.fluid},${option.direction}">${option.fluid}</option>`
                            );
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

            const CardioValue = 
                [
                    {heart_rate:{
                        high: 100,
                        low: 60
                    }},{
                    BpSystolic:{
                        high: 120,
                        low: 80
                    }},
                    {BpDiastolic:{
                        high: 80,
                        low: 60
                    }},{
                    Spo2:{
                        high: 100,
                        low: 95
                    }},{
                    Temperature:{
                        high: 37.5,
                        low: 36.5
                    }},{
                    Peripheralpulses:{
                        high: 100,
                        low: 60
                    }},{
                    Rhythm:{
                        high: 100,
                        low: 60
                    }},
                    {RespiratoryRate:{
                        high: 20,
                        low: 12
                    }},{
                    CapillaryRefillTime:{
                        high: 2,
                        low: 1
                    }},{
                    CVP:{
                        high: 8,
                        low: 4
                    }},
                    {
                    MAP:{
                        high: 100,
                        low: 60
                    }},
                    {
                        label:{
                        hight: 0,
                        low: 0}
                    },
                    {
                        Recordedby:{
                            high: 0,
                            low: 0
                        }
                    }
                   
                ];

            function getFluidData() {
                $.ajax({
                    type: 'GET',
                    url: `{{ URL::to('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/fluid-assessment/${activeDay}/${viewtype}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        let inputData = data.data;
                        let outputData = data.outputData;
                        let inputRow = data.inputFluids;
                        let outputRow = data.outputFluids;
                        let countInput = data.inputNumbers;
                        let countOutput = data.outputNumbers;

                        // let inputData = data.input;
                        // console.log('from fluid data', inputData, 'countlength', countOutput);
                        if ($.isEmptyObject(inputData) && $.isEmptyObject(outputData)) {

                            $("#table-fluid").html('<h2 class="text-center">No Fluid Data Found</h2>');

                        } else {

                            var inputtable = $('<table class="table table-bordered"></table>');
                            var headerIndicator = $('<thead></thead>');

                            if (!$.isEmptyObject(inputData)) {

                                let inputRowsHeader = countInput + 2;
                                var headerRow = $('<tr></tr>');
                                headerRow.append(
                                    `<th class="bg-yellow-300 fw-bold text-center" colspan="${inputRowsHeader}">Input</th>`
                                );
                                headerIndicator.append(headerRow);
                                var headerRow = $('<tr></tr>');
                                headerRow.append('<th class="bg-yellow-300">Recorded At</th>');
                                $.each(inputRow, function(index, value) {

                                    headerRow.append('<th class="text-center">' + value +
                                        '</th>');
                                });
                                headerRow.append(`<th class="text-center"> Created By </th>`);

                                headerIndicator.append(headerRow);
                                inputtable.append(headerIndicator);
                                // Create a table body rows

                                const tableRows = {};
                                let numberOfInputRows = inputData.label.length;


                                $.each(inputData, function(key, value) {
                                    $.each(value, function(index, item) {
                                        for (let i = 0; i < numberOfInputRows; i++) {
                                            if (!tableRows[i]) {
                                                tableRows[i] = [];
                                            }
                                            if (i === index) {
                                                if (key != "fluids") {
                                                    tableRows[i].push(item);
                                                }
                                            }
                                        }
                                    })
                                });

                                $.each(tableRows, function(key, value) {

                                    var row = $('<tr></tr>');

                                    value.splice(1, 0, ...inputData.fluids[key]);
                                    for (var i = 0; i < value.length; i++) {

                                        row.append('<td class="border-1 px-2">' + value[
                                            i] + '</td>');
                                    }
                                    inputtable.append(row);

                                });
                            }
                            if (!$.isEmptyObject(outputData)) {
                                var table = $('<table class="table table-bordered"></table>');
                                var headerIndicator = $('<thead></thead>');
                                let outputRowsHeader = countOutput + 2;
                                var headerRow = $('<tr></tr>');
                                headerRow.append(
                                    `<th class="bg-danger-300 fw-bold text-center" colspan="${outputRowsHeader}">Output</th>`
                                );
                                headerIndicator.append(headerRow);
                                var headerRow = $('<tr></tr>');
                                headerRow.append('<th class="bg-yellow-300">Recorded At</th>');
                                $.each(outputRow, function(index, value) {

                                    headerRow.append('<th class="text-center">' + value +
                                        '</th>');
                                });
                                headerRow.append(`<th class="text-center"> Created By </th>`);

                                headerIndicator.append(headerRow);
                                table.append(headerIndicator);
                                // Create a table body rows
                                var tablebody = $('<tbody></tbody>');
                                const tableRows = {};
                                let numberOfOutputRows = outputData.label.length;
                                $.each(outputData, function(key, value) {
                                    $.each(value, function(index, item) {
                                        for (let i = 0; i < numberOfOutputRows; i++) {
                                            if (!tableRows[i]) {
                                                tableRows[i] = [];
                                            }
                                            if (i === index) {
                                                if (key != "fluids") {
                                                    tableRows[i].push(item);
                                                }
                                            }
                                        }
                                    })
                                });
                                console.log(outputData, 'from outputData');
                                $.each(tableRows, function(key, value) {
                                    var row = $('<tr></tr>');
                                    value.splice(1, 0, ...outputData.fluids[key]);
                                    for (var i = 0; i < value.length; i++) {

                                        row.append('<td class="px-2 border-1">' + value[
                                            i] + '</td>');
                                    }

                                    table.append(row);
                                });
                            }
                            $('#table-fluid').html(inputtable);
                            $('#table-fluid').append(table);
                        }

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
                    url: `{{ url('/') }}/show-cardio/{{ $patient->latestPatientCare->id }}/${activeDay}/${viewtype}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {

                        let myData = data.data;
                        // console.log(myData);
                        if ($.isEmptyObject(myData)) {

                            $("#table-cardio").html(
                                '<h2 class="text-center">No Cardio Data Found</h2>');

                        } else {

                            var table = $('<table class="table table-bordered table-striped"></table>');
                            var headerIndicator = $('<thead></thead>');
                            // Create a table header row
                            var headerRow = $('<tr></tr>');

                            headerRow.append('<th class="bg-yellow-300">Recorded at</th>');
                            for (var i = 0; i < data.label.length; i++) {

                                headerRow.append('<th>' + data.label[i] + '</th>');
                            }
                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);

                            const tableRows = {};
                            let numberOfRows = myData.label.length;
                            // console.log(numberOfRows, 'from cardioData');
                            $.each(myData, function(key, value) {
                                console.log(key, "from eagle");
                                
                               const comparativeValue = CardioValue.find(item => Object.keys(item)[0] === key)[key];

                              
                                // console.log(comparativeValue, 'from comparative value');
                               console.log(comparativeValue, 'from comparative value');
                                $.each(value, function(index, item) {
                                    
                                    for (let i = 0; i < numberOfRows; i++) {
                                        if (!tableRows[i]) {
                                            tableRows[i] = [];
                                        }
                                        if (i === index) {
                                            let displayDynamics;
                                          if(item > comparativeValue.high ){
                                            displayDynamics = `<span class="text-danger">${item}</span>`
                                          }else if(item < comparativeValue.low ){
                                            displayDynamics = `<span class="text-primary">${item}</span>`
                                          }else{
                                            displayDynamics = item;
                                          }
                                            tableRows[i].push(displayDynamics);
                                            // tableRows[i].push(item);
                                        }
                                    }
                                })


                            });

                            $.each(tableRows, function(key, value) {
                                var row = $('<tr></tr>');

                                for (var i = 0; i < value.length; i++) {

                                    row.append('<td class="px-1 border-1">' + value[i] +
                                        '</td>');
                                }
                                table.append(row);
                            });
                            // Append the table to the body

                            $("#table-cardio").html(table);

                        }

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
                    url: `{{ URL::to('/') }}/show/{{ $patient->latestPatientCare->id }}/${activeDay}/${
                        viewtype}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {

                        // $('#chart-3').html(data.data);
                        let respData = data.data;
                        console.log(respData);
                        if ($.isEmptyObject(respData)) {

                            $("#table-resp-table").html(
                                '<h2 class="text-center">No Respiratory Data Found</h2>');

                        } else {

                            var table = $('<table class="table table-bordered"></table>');
                            var headerIndicator = $('<thead></thead>');
                            // Create a table header row
                            var headerRow = $('<tr></tr>');

                            headerRow.append('<th class="bg-dark-300 text-light"> Recorded at</th>');
                            for (var i = 0; i < data.label.length; i++) {

                                headerRow.append('<th>' + data.label[i] + '</th>');
                            }
                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);
                            const tableRows = {};
                            let numberOfRows = respData.label.length;
                            // console.log(numberOfRows, 'from respData');
                            $.each(respData, function(key, value) {
                                // console.log(key, "from eagle");
                                $.each(value, function(index, item) {
                                    for (let i = 0; i < numberOfRows; i++) {
                                        if (!tableRows[i]) {
                                            tableRows[i] = [];
                                        }
                                        if (i === index) {
                                            tableRows[i].push(item);
                                        }
                                    }
                                });

                            });
                            // console.log(tableRows, "from eagle");

                            $.each(tableRows, function(key, value) {
                                var row = $('<tr></tr>');

                                for (var i = 0; i < value.length; i++) {

                                    row.append('<td class="px-1 border-1">' + value[i] +
                                        '</td>');
                                }
                                table.append(row);
                            });
                            // table.append(row);


                            // Create table body rows
                            $("#table-resp-table").html(table);
                        }

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
                    url: `{{ URL::to('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/medication/${activeDay}/${viewtype}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        // $('#chart-3').html(data.data);5
                        let medicationData = data.data;
                        console.log(medicationData);
                        if ($.isEmptyObject(medicationData)) {
                            $("#table-medication").html(
                                '<h2 class="text-center">No Medication Data Found</h2>');
                        } else {
                            var table = $('<table class="table table-bordered"></table>');
                            var headerIndicator = $('<thead></thead>');
                            // Create a table header row
                            var headerRow = $('<tr></tr>');
                            headerRow.append('<th class="bg-dark-300 text-light">Recorded at</th>');
                            $.each(data.medication_names, function(index, value) {
                                headerRow.append('<th>' + value + '</th>');
                            });
                            headerRow.append(`<th class="text-center">Recorded by</th>`);
                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);
                            let tableBody = $('<tbody></tbody>');
                            let tableRows = {};
                            let numberOfRows = medicationData.label.length;
                            $.each(medicationData, function(key, value) {
                                $.each(value, function(index, item) {
                                    for (let i = 0; i < numberOfRows; i++) {
                                        if (!tableRows[i]) {
                                            tableRows[i] = [];
                                        }
                                        if (i === index) {
                                            if (key != "medications") {
                                                tableRows[i].push(item);
                                            }
                                        }
                                    }
                                });

                            });
                            $.each(tableRows, function(key, value) {
                                var row = $('<tr></tr>');
                                value.splice(1, 0, ...medicationData.medications[key]);
                                for (var i = 0; i < value.length; i++) {
                                    row.append('<td class="px-2 border-1">' + value[i] +
                                        '</td>');
                                }
                                table.append(row);
                            });

                            $("#table-medication").html(table);
                        }

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
                    url: `{{ URL::to('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/nutritions/${activeDay}/${viewtype}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        // $('#chart-3').html(data.data);
                        let nutritionData = data.data;

                        if ($.isEmptyObject(nutritionData)) {
                            $("#table-nutrition").html(
                                '<h2 class="text-center">No Nutrition Data Found</h2>');
                        } else {
                            var table = $('<table class="table table-bordered"></table>');
                            var headerIndicator = $('<thead></thead>');
                            // Create a table header row
                            var headerRow = $('<tr></tr>');
                            headerRow.append('<th class="bg-dark-300 text-light">Recorded at</th>');
                            $.each(data.nutrition_names, function(index, value) {
                                headerRow.append('<th>' + value + '</th>');
                            });
                            headerRow.append(`<th class="text-center">Recorded by</th>`);
                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);

                            // Create table body
                            const tableRows = {};
                            let numberOfRows = nutritionData.label.length;
                            $.each(nutritionData, function(key, value) {
                                $.each(value, function(index, item) {
                                    for (let i = 0; i < numberOfRows; i++) {
                                        if (!tableRows[i]) {
                                            tableRows[i] = [];
                                        }
                                        if (i === index) {
                                            if (key != "nutrition") {
                                                tableRows[i].push(item);
                                            }
                                        }
                                    }
                                });
                            });
                            $.each(tableRows, function(key, value) {
                                var row = $('<tr></tr>');
                                value.splice(1, 0, ...nutritionData.nutrition[key]);
                                for (var i = 0; i < value.length; i++) {
                                    row.append('<td class="border-1 px-2">' + value[i] +
                                        '</td>');
                                }
                                table.append(row);
                            });

                            $("#table-nutrition").html(table);
                        }

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
                    url: `{{ URL::to('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/neuro-assessment/${activeDay}/${viewtype}`,
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
                            headerRow.append(`<th class="bg-danger-300">TimeTaken</th>
                            <th>Eyes Open</th><th>Sedated</th><th>Intubated</th><th>Best Motor response
                                (BMR)</th><th>Best Verbal response (BVR)</th>
                                <th>Sedation Score</th>
                                <th>Pupil Diameter</th><th>Recorded by</th>`);


                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);
                            var row = $('<tr></tr>');
                            $.each(neuroData, function(key, value) {

                                for (var i = 0; i < value.length; i++) {
                                    row.append('<td class="border-1 px-2">' + value[i] +
                                        '</td>');
                                }
                                table.append(row);
                            })

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
                                    '';
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
                    url: `{{ URL::to('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/skin-care/${activeDay}/${viewtype}`,
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
                            headerRow.append(
                                `<th class="bg-dark-300 text-light">Date</th>
                    <th >Wound Dressings</th><th >Drain Output</th><th>Skin Integrity</th><th>Recorded by</th>`
                            );
                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);
                            $.each(skinData, function(key, value) {
                                var row = $('<tr></tr>');
                                row.append('<th class="ps-2 border-1">' + value.new_date + '</th><th class="ps-2 border-1">' +
                                    ((value.wound_dressings) ? value.wound_dressings :
                                        '-') + '</th><th>' + ((value.drain_output) ? value
                                        .drain_output : '-') +
                                    '</th><th class="ps-2 border-1">' + ((value.skin_integrity) ? value
                                        .skin_integrity : '-') + '</th><th class="ps-2 border-1">' + ((value
                                        .recorded_by) ? value.recorded_by : '-') +
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
                      <th>Time</th><th>Description</th><th>Duration</th><th>Intervention</th><th>Recorded By</th>`);
                            table.append(headerRow);
                            $.each(seizureData, function(key, value) {
                                table.append(`<tr>
                                <td class="px-2 border-1 px-1">${value.new_date}</td>
                                <td class="px-2 border-1 px-1">${value.time}</td>
                                <td class="px-2 border-1 px-1">${value.description}</td>
                                <td class="px-2 border-1 px-1">${value.durations}</td>
                                <td class="px-2 border-1 px-1">${value.intervention}</td>
                                <td class="px-2 border-1 px-1">${value.recorded_by}</td>
                                </tr>`);
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
                    url: `{{ url('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/dailynotes/${activeDay}/${viewtype}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        // $('#chart-3').html(data.data);
                        let dailyData = data
                        console.log(dailyData, 'hello from daily data');
                        if ($.isEmptyObject(dailyData)) {
                            $("#table-daily").html(
                                '<h2 class="text-center">No Handover Notes Recorded</h2>');
                        } else {
                            var table = $(
                                '<table class="table table-bordered" id="form-table-daily"></table>'
                            );
                            var headerIndicator = $('<thead></thead>');
                            // Create a table header row
                            var headerRow = $('<tr></tr>');
                            headerRow.append(`<th class="bg-dark-300 text-light">Created at</th>
                    <th class="bg-dark-300 text-light">Duty</th><th class="bg-dark-300 text-light">Details</th>
                    <th class="bg-dark-300 text-light">Recorded By</th>
                   `);
                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);
                            $.each(dailyData, function(key, value) {
                                var row = $(`
                                    <tr>
                                        <td class="ps-2 border-1">${value.new_date}</td>
                                        <td class="ps-2 border-1">${value.duty_period}</td>
                                      <td class="ps-2 border-1">${value.daily_notes}</td>
                                        <td class="ps-2 border-1">${value.recorded_by}</td>
                                    </tr>
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
                    <th class="bg-dark-300 text-light">Date Inserted</th><th class="bg-dark-300 text-light">Recorded By</th>
                   `);
                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);
                            $.each(invasiveData, function(key, value) {
                                var row = $('<tr></tr>');
                                row.append(`<th class="ps-2 border-1">${value.invasive_lines}</th>
                    <td class="ps-2 border-1">${value.new_date}</td>
                    <td class="ps-2 border-1">${value.recorded_by}</td>
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

            function getRenalData() {
                $.ajax({
                    type: 'GET', // or 'POST' if required
                    url: `{{ url('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/renal-fluids/${activeDay}`,
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
                                row.append(`<td class="border-1 px-1">${key}</td>
                                <td class="border-1 px-2"> ${value}</td>
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
                    url: `{{ url('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/daily-treatment/${activeDay}`,
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
                                row.append(`<td class="border-1 px-1">${value.content}</td><td clas>${value.intervention}</td><td class="border-1 px-1">${value.recorded_by}</td>`)

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
                    url: `{{ url('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/physician-order/${activeDay}/${viewtype}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {
                        let physicianData = data;

                        if ($.isEmptyObject(physicianData)) {
                            $('#table-physician').html(
                                `<h1 class="text-center"> No Physician Note </h1>`)
                            $('#phy-notes-count').html(0)
                        } else {
                            $('#phy-notes-count').html(physicianData.length)
                            var table = $(
                                '<table class="table table-bordered" id="form-table-progress"></table>'
                            );
                            var headerIndicator = $('<thead></thead>');
                            // Create a table header row
                            var headerRow = $('<tr></tr>');
                            headerRow.append(
                                `<th>created at</th><th class="bg-dark-300 text-light">Physician Notes</th><th>Recorded By</th>`
                            );
                            headerIndicator.append(headerRow);
                            table.append(headerIndicator);
                            $.each(physicianData, function(key, value) {
                                var row = $(`<tr>
                                    <td class="border-1 px-1"">${value.new_date}</td>
                                    <td class="border-1 px-1">
                                    ${value.content}</td>
                                    <td class="border-1 px-1">
                                           <span class="badge bg-gradient bg-info-subtle">  ${value.recorded_by} </span>
                                        </td>
                                    </tr>
                                  `);

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

            function summaryView() {
                $('.chart-space').hide();
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
            }

            let chartIndicator = false;
            summaryView();
            $('#view-types').on('click', '#summary-view', function() {
                viewtype = 'summary';
                chartIndicator = false;
                summaryView();
                showSelectedCards();
                if ($('#summary-view').hasClass('btn-outline-primary')) {

                    $('#summary-view').removeClass('btn-outline-primary');
                    $('#summary-view').addClass('btn-primary');
                }
                if ($('#details-view').hasClass('btn-purple')) {
                    $('#details-view').removeClass('btn-purple');
                    $('#details-view').addClass('btn-outline-purple');
                }
                if ($('#chart-view').hasClass('btn-info')) {
                    $('#chart-view').removeClass('btn-info');
                    $('#chart-view').addClass('btn-outline-info');
                }

            });
            $('#view-types').on('click', '#details-view', function() {
                viewtype = 'details'
                chartIndicator = false;
                summaryView();
                showSelectedCards();
                if ($('#details-view').hasClass('btn-outline-purple')) {
                    $('#details-view').removeClass('btn-outline-purple');
                    $('#details-view').addClass('btn-purple');
                }
                if ($('#summary-view').hasClass('btn-primary')) {
                    $('#summary-view').removeClass('btn-primary');
                    $('#summary-view').addClass('btn-outline-primary');
                }
                if ($('#chart-view').hasClass('btn-info')) {
                    $('#chart-view').removeClass('btn-info');
                    $('#chart-view').addClass('btn-outline-info');
                }


            });
            $('#view-types').on('click', '#chart-view', function() {
                // chartView();
                viewtype = 'details';
                chartIndicator = true;
               $('#table-cardio').empty();
               $('#table-resp-table').empty();
               $('#table-fluid').empty();

                drawCardioChart();
                drawRespChart();
                drawFluidChart();
                hideSelectedCards();

                if ($('#chart-view').hasClass('btn-outline-info')) {
                    $('#chart-view').removeClass('btn-outline-info');
                    $('#chart-view').addClass('btn-info');
                }
                if ($('#summary-view').hasClass('btn-primary')) {
                    $('#summary-view').removeClass('btn-primary');
                    $('#summary-view').addClass('btn-outline-primary');
                }
                if ($('#details-view').hasClass('btn-purple')) {
                    $('#details-view').removeClass('btn-purple');
                    $('#details-view').addClass('btn-outline-purple');
                }
            });

            $('#table-lab').on('click', '.result', function() {
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




                        $('#toast-1 .toast-body').html(response.message);
                        $('#toast-1').toast('show');
                        $('#modalXl').modal('hide');
                        $('#cardio-form')[0].reset();
                        $('#cardio-save').prop('disabled', false);
                        $('#cardio-save-spinner').hide();
                        $('#cardio-charting').hide();
                          if(chartIndicator){
                            drawCardioChart();
                        } else{
                            getCardioData();
                        }

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
                        $('#respiratory-charting').hide();
                        if(chartIndicator){
                            drawRespChart();
                        } else{
                            getRespData();
                        }

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
            //Adding fluid balance
            $('#new-fluid').hide();
            var rowIdx = 0;
            let fluid_name, fluid_volume, fluid_direction;
            const fluid_names = [];
            const fluid_directions = [];
            const fluid_volumes = [];

            $('#select-fluid').on('change', function() {
                if ($(this).val() == 'others') {
                    $('#new-fluid').show();
                } else {
                    $('#new-fluid').hide();
                    let fluid_array = $(this).val().split(',');
                    fluid_name = fluid_array[0];
                    fluid_direction = fluid_array[1];
                }

            });
            $('#fluid-error').hide();
            $('#fluid-volume').on('blur', function() {
                fluid_volume = $(this).val();
            });
            $('#fluid-type-name').on('blur', function() {
                fluid_name = $(this).val();
            });
            $('#fluid-type-direction').on('change', function() {
                fluid_direction = $(this).val();
                console.log(fluid_direction);
            });
            $('#fluid-record-add').on('click', function() {
                console.log(fluid_names)

                if (fluid_name && fluid_direction && fluid_volume) {
                    rowIdx++;
                    let occurence = fluidNameCount(fluid_names, fluid_name);
                    if (occurence > 0) {
                        fluid_name = '';
                        fluid_direction = '';
                        fluid_volume = '';

                        $('#fluid-error').text('Fluid already added');
                        $('#fluid-error').show();
                        setTimeout(() => {
                            $('#fluid-error').hide();
                        }, 3000);
                        return;

                    }
                    fluid_names.push(fluid_name);
                    const row = `<tr id="row-${rowIdx}">
                    <td>${fluid_name}</td>
                    <td>${fluid_volume}</td>
                    <td>${fluid_direction}
                        <input type="hidden" name="fluid_name[]" value="${fluid_name}">
                        <input type="hidden" name="fluid_volume[]" value="${fluid_volume}">
                        <input type="hidden" name="fluid_direction[]" value="${fluid_direction}">
                    </td>

                    <td>
                        <button type="button" class="btn btn-danger removeFluid">Remove</button>
                    </td>
                </tr>`;
                    $('#fluid-record-table tbody').append(row);
                } else {
                    $('#fluid-error').text('select all fields').show();
                    setTimeout(() => {
                        $('#fluid-error').hide();
                    }, 3000);
                }
                $('#fluid-type-name').val('');
                $('#fluid-volume').val('');


            });

            $('#fluid-record-table tbody').on('click', '.removeFluid', function() {
                let rowId = $(this).closest('tr').attr('id');
                $(this).closest('tr').remove();;
                fluid_names.splice($(`#row-${rowId}>td`).html(), 1);
            })

            function fluidNameCount(arr, element) {
                return arr.filter(item => item === element).length;
            }
            //fluid balance form
            $('#fluid-save-spinner').hide();
            $('#fluid-form').submit(function(event) {
                event.preventDefault(); // Prevent default form submission
                if (fluid_names.length < 1) {
                    $('#fluid-error').text('No fluid and volume added').show();
                    setTimeout(() => {
                        $('#fluid-error').hide();
                    }, 3000);
                    return;
                }

                var fluidData = $(this).serialize(); // Serialize form data

                $('#fluid-save').prop('disabled', true);
                $('#fluid-save-spinner').show();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('fluid.store') }}', // Replace with your server-side script URL
                    data: fluidData,
                    success: function(response) {

                        console.log(response);
                        $('#fluid-record-table tbody').html('');
                        $('#toast-1 .toast-body').html(response.message);
                        $('#toast-1').toast('show');
                        $('#modal-fluid').modal('hide');

                        $('#fluid-form')[0].reset();
                        $('#fluid-save').prop('disabled', false);
                        $('#fluid-save-spinner').hide();
                        $('#new-fluid').hide();
                        $('#chartFluid').hide();
                        if(chartIndicator){
                            drawFluidChart();
                        } else{
                            getFluidData();
                        }

                        getFluidSelect();
                        getRenalData();
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
            let medRowIdx = 0;
            let medication_name, medication_dose;
            const medication_names = [];
            //medication form

            $('#new-medication').hide();
            $('#select-medication').on('change', function() {
                var selectVal = $(this).val();
                console.log(selectVal);
                if ($(this).val() == 'others') {
                    $('#new-medication').show();
                } else {
                    $('#new-medication').hide();
                    medication_name = $(this).val();
                }
            });
            $('#medication-error').hide();
            $('#medication_name').on('blur', function() {
                medication_name = $(this).val();
            });
            $('#medication_dosage').on('blur', function() {
                medication_dose = $(this).val();

            });

            function medicationNameCount(arr, element) {
                return arr.filter(item => item === element).length;
            }
            $('#medication-record-add').on('click', function() {
                console.log(medication_name, medication_dose);
                if (medication_name && medication_dose) {
                    medRowIdx++;
                    let occurence = medicationNameCount(medication_names, medication_name);
                    if (occurence > 0) {
                        medication_name = '';
                        medication_dose = '';
                        $('#medication-error').text('Medication already added').show();
                        setTimeout(() => {
                            $('#medication-error').hide();
                        }, 3000);
                        return;
                    }
                    medication_names.push(medication_name);
                    const row = `<tr id="row-${medRowIdx}">
                    <td>${medication_name}</td>
                    <td>${medication_dose}
                        <input type="hidden" name="medication_name[]" value="${medication_name}">
                        <input type="hidden" name="medication_dose[]" value="${medication_dose}">
                    </td>

                    <td>
                        <button type="button" class="btn btn-danger removeMedication">Remove</button>
                    </td>
                </tr>`;

                    $('#medication-record-table tbody').append(row);
                } else {
                    $('#medication-error').text('select all fields').show();
                    setTimeout(() => {
                        $('#medication-error').hide();
                    }, 3000);
                }
                $('#medication_name').val('');
                $('#medication_dosage').val('');
                medication_name = '';
                medication_dose = '';
            });
            $('#medication-record-table tbody').on('click', '.removeMedication', function() {
                let rowId = $(this).closest('tr').attr('id');
                $(this).closest('tr').remove();
                medication_names.splice($(`#row-${rowId}>td`).html(), 1);
            })


            $('#medication-save-spinner').hide();
            $('#medication-form').submit(function(event) {
                event.preventDefault(); // Prevent default form submission
                if (medication_names.length < 1) {
                    $('#medication-error').text('kindly fill all fields').show();
                    setTimeout(() => {
                        $('#medication-error').hide();
                    }, 3000);
                    return;
                }
                var medicationData = $(this).serialize(); // Serialize form data
                $('#medication-save').prop('disabled', true);
                $('#medication-save-spinner').show();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('medication.store') }}', // Replace with your server-side script URL
                    data: medicationData,
                    success: function(response) {

                        console.log(response);
                        $('#medication-record-table tbody').html('');
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
            let nutritionRowIdx = 0;
            let nutrition_name, nutrition_dose;
            const nutrition_names = [];
            $('#new-nutrition').hide();
            $('#select-nutrition').on('change', function() {
                var selectVal = $(this).val();
                console.log(selectVal);
                if ($(this).val() == 'others') {
                    $('#new-nutrition').show();
                } else {
                    $('#new-nutrition').hide();
                    nutrition_name = $(this).val();
                }
            });
            $('#nutrition-error').hide();
            $('#nutrition_name').on('blur', function() {
                nutrition_name = $(this).val();
            });
            $('#nutrition_dosage').on('blur', function() {
                nutrition_dose = $(this).val();

            });

            function nutritionNameCount(arr, element) {
                return arr.filter(item => item === element).length;
            }
            $('#nutrition-record-add').on('click', function() {

                if (nutrition_name && nutrition_dose) {
                    nutritionRowIdx++;
                    let occurence = nutritionNameCount(nutrition_names, nutrition_name);
                    if (occurence > 0) {
                        nutrition_name = '';
                        nutrition_dose = '';
                        $('#nutrition-error').text('Nutrition already added').show();
                        setTimeout(() => {
                            $('#nutrition-error').hide();
                        }, 3000);
                        return;
                    }
                    nutrition_names.push(nutrition_name);
                    const row = `<tr id="row-${nutritionRowIdx}">
                    <td>${nutrition_name}</td>
                    <td>${nutrition_dose}
                        <input type="hidden" name="nutrition_name[]" value="${nutrition_name}">
                        <input type="hidden" name="nutrition_dose[]" value="${nutrition_dose}">
                    </td>

                    <td>
                        <button type="button" class="btn btn-danger removeNutrition">Remove</button>
                    </td>
                </tr>`;

                    $('#nutrition-record-table tbody').append(row);
                } else {
                    $('#nutrition-error').text('select all fields').show();
                    setTimeout(() => {
                        $('#nutrition-error').hide();
                    }, 3000);
                }
                $('#nutrition_name').val('');
                $('#nutrition_dosage').val('');
                nutrition_name = '';
                nutrition_dose = '';
            });
            $('#nutrition-record-table tbody').on('click', '.removeNutrition', function() {
                let rowId = $(this).closest('tr').attr('id');
                $(this).closest('tr').remove();
                nutrition_names.splice($(`#row-${rowId}>td`).html(), 1);
            })
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
            //physician form
            $('#physician-save-spinner').hide();
            $('#physician-form').submit(function(event) {
                event.preventDefault();
                var physicianData = $(this).serialize();
                $('#physician-save').prop('disabled', true);
                $('#physician-save-spinner').show();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('physician.store') }}',
                    data: physicianData,
                    success: function(response) {
                        console.log(response);
                        $('#toast-1 .toast-body').html(response.message);
                        $('#toast-1').toast('show');
                        $('#modal-physician').modal('hide');
                        $('#physician-form')[0].reset();
                        $('#physician-save').prop('disabled', false);
                        $('#physician-save-spinner').hide();
                        getPhysicianData();
                    },
                    error: function(error) {
                        // Handle errors$
                        $.each(error.responseJSON.errors, function(key, value) {
                            $('#physician-form').append('<div class="text-danger">' +
                                value + '</div>');
                        });
                        $('#physician-save').prop('disabled', false);
                        $('#physician-save-spinner').hide();
                    }
                });
            });
            //progress form
            $('#progress-save-spinner').hide();
            $('#progress-form').submit(function(event) {
                event.preventDefault();
                var progressData = $(this).serialize();
                $('#progress-save').prop('disabled', true);
                $('#progress-save-spinner').show();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('dailyTreatment.store') }}',
                    data: progressData,
                    success: function(response) {
                        console.log(response);
                        $('#toast-1 .toast-body').html(response.message);
                        $('#toast-1').toast('show');
                        $('#modal-progress').modal('hide');
                        $('#progress-form')[0].reset();
                        $('#progress-save').prop('disabled', false);
                        $('#progress-save-spinner').hide();
                        getProgressData();
                    },
                    error: function(error) {
                        // Handle errors$
                        $.each(error.responseJSON.errors, function(key, value) {
                            $('#progress-form').append('<div class="text-danger">' +
                                value + '</div>');
                        });
                        $('#progress-save').prop('disabled', false);
                        $('#progress-save-spinner').hide();
                    }
                });
            });
            $('#pupil-diameter').on('change', function() {
                $('#value-pupil-diameter').html(this.value);
            })
            $('#active-day').on('change', function() {
                activeDay = $('#active-day').val();
                if(chartIndicator){
                     $('#table-cardio').empty();
               $('#table-resp-table').empty();
               $('#table-fluid').empty();

                drawCardioChart();
                drawRespChart();
                drawFluidChart();
                hideSelectedCards();
                }else{

                    showSelectedCards();
                    summaryView();
                }


            });

        });
    </script>
@endpush

@section('content')



    <div class="card border-theme border-1 sticky-md-top mb-1 shadow-lg" style="top:10px;">
        <div class="card-body row align-items-center">
            <div class="col-md-12">
                <div class="row" id="patient-info">
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
                            {{ $patient->latestPatientCare->condition }}</h5>
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
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#modal-discharge"> Discharge Patient</button>
                        <div class="form-group row my-1 rounded bg-green-200 px-2 align-items-center">
                            <label for="active-day" class="form-label fw-bold">Active Day</label>

                            <select class="form-select form-select-lg mb-3" id="active-day">
                                @foreach ($dates as $key => $date)
                                    <option value="{{ $date->format('Y-m-d') }}" @selected($date == today())>
                                        {{ $date->format('d-m-y') }} - Day {{ $key + 1 }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="bottom-0 mt-2">
                            <button class="btn btn-sm btn-teal" id="patient-info-summary">view patient limited
                                information</button>
                        </div>

                    </div>
                </div>
                <div class="row" id="patient-info-2">
                    <div class="col-sm-6 col-md-6">
                        <h4 class="mb-0"> Name: <span
                                class=
                                    "fw-bold text-gray-emphasis">{{ $patient->fullname }}</span>
                        </h4>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <h5 class="text-muted my-0 text-gray-emphasis">Diagnosis: &nbsp;<span
                                class="fw-bold">{{ $patient->latestPatientCare->diagnosis }}</span></h5>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <h5 class="text-muted my-0 text-gray-emphasis"><span class="fw-bold">Next of Kin:
                                &nbsp;</span>{{ $patient->next_of_kin }}</h5>
                        <div class="bottom-0 mt-2">
                            <button class="btn btn-sm btn-teal" id="patient-info-full">view full patient
                                information</button>
                        </div>
                    </div>

                </div>
                <div class="row bottom-0 mt-2 border-top border-2 border-primary" id="view-types">
                    <div class="col-md-6">
                        <h5> View Type: </h5>
                        <div class="d-flex justify-content-center align-items-center">
                            <button type="button" class="btn btn-primary mx-2" id="summary-view">Summary view</button>
                            <button type="button" class="btn btn-outline-purple mx-2" id="details-view">Details
                                view</button>
                            <button type="button" class="btn btn-outline-info mx-2" id="chart-view">Chart view</button>
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card row mt-2 p-2 border-teal border-1 rounded">
        <div class="col-lg-12" id="cardio">
            <div class="card h-100 mt-2">
                <div class="card-header bg-yellow-300 d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="mb-1"> Cardiovascular Assessment </h5>
                    </div>
                    <div class="d-flex gap-2 align-items-center">
                        @can('add-cardio')
                            <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal"
                                    data-bs-target="#modalXl"><i class="fa fa-plus" ></i></button>
                        @endcan

                        <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        <a href="#" data-toggle="card-expand"
                            class="text-white text-opacity-50 text-decoration-none"><i class="fa fa-fw fa-expand"></i></a>
                    </div>
                </div>


                <!-- BEGIN card-body -->
                <div class="card-body">
                    <div class="table-responsive mb-3" id="table-cardio">

                    </div>

                        <div id="cardio-charting" class="chart-space"></div>



                </div>
                <!-- END card-body -->
            </div>
        </div>


        <div class="col-lg-12" id="resp-card">
            <div class="card h-100 mt-2">
                <div class="card-header bg-dark d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="mb-1 text-white"> Respiratory Assessment</h5>
                    </div>
                    <div class="d-flex gap-2 align-items-center">
                        @can('add-respiratory')
                            <button class="btn btn-sm btn-outline-light"  data-bs-toggle="modal" data-bs-target="#modal-resp"><i class="fa fa-plus text-white cursor-pointer"
                                   ></i></button>
                        @endcan

                        <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                        <a href="#" data-toggle="card-expand"
                            class="text-white text-opacity-20 text-decoration-none"><i class="fa fa-fw fa-expand"></i></a>
                    </div>
                </div>


                <!-- BEGIN card-body -->
                <div class="card-body">

                    <div class="table-responsive mb-3" id="table-resp-table">

                    </div>

                        <div id="respiratory-charting" class="chart-space"></div>



                </div>
                <!-- END card-body -->

            </div>
        </div>


        <div class="col-lg-12" id="fluid-card">
            <div class="card h-100 mt-2">
                <!-- BEGIN card-body -->
                <div class="card-header bg-warning d-flex gap-2 align-items-center">

                    <div class="flex-grow-1">
                        <h5 class="mb-1">Fluid Balance</h5>

                    </div>
                    @can('add-fluid-balance')
                        <button class="btn btn-sm btn-outline-dark"  data-bs-toggle="modal" data-bs-target="#modal-fluid">
                            <i class="fa fa-plus cursor-pointer"></i>
                        </button>
                    @endcan

                    <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                    <a href="#" data-toggle="card-expand"
                        class="text-white text-opacity-20 text-decoration-none"><i class="fa fa-fw fa-expand"></i></a>

                </div>
                <div class="card-body">
                    <div class="table-responsive mb-3" id="table-fluid">

                    </div>

                    <div id="chartFluid" class="chart-space"></div>


                </div>
                <!-- END card-body -->
            </div>
        </div>
        <div class="col-lg-12" id="renal-card">
            <div class="card h-100 mt-2">
                <div class="card-header bg-gradient bg-purple bg-opacity-30 d-flex gap-2 align-items-center">
                    <div class="d-flex mb-3 gap-1">
                        <div class="flex-grow-1">
                            <h5 class="mb-1"> Renal Assessment </h5>

                        </div>

                        <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                    </div>
                </div>
                <!-- BEGIN card-body -->
                <div class="card-body">

                    <div id="table-renal" class="table-responsive"></div>
                </div>
                <!-- END card-body -->
            </div>
        </div>
        <div class="col-lg-12" id="nutrition-card">
            <div class="card h-100 mt-2">
                <!-- BEGIN card-body -->
                <div class="card-header bg-gradient bg-teal-400 d-flex gap-2 align-items-center">

                    <div class="flex-grow-1">
                        <h5 class="mb-1">Nutrition</h5>

                    </div>
                    @can('add-nutrition')
                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modal-nutrition">
                            <i class="fa fa-plus" ></i>
                        </button>
                    @endcan

                    <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                    <a href="#" data-toggle="card-expand"
                        class="text-white text-opacity-20 text-decoration-none"><i class="fa fa-fw fa-expand"></i></a>

                </div>
                <div class="card-body">
                    <div class="table-responsive" id="table-nutrition">

                    </div>
                    <div id="nutrition-charting" class="chart-space"></div>

                </div>
                <!-- END card-body -->
            </div>
        </div>

        <div class="col-lg-12" id="neuro-card">
            <div class="card h-100 mt-2">
                <div id="neuroChart"></div>
                <!-- BEGIN card-body major -->
                <div class="card-header bg-danger d-flex gap-2 align-items-center">

                    <div class="flex-grow-1">
                        <h5 class="mb-1">Neurological Assessment</h5>
                    </div>
                    @can('add-neuro')
                        <button type="button" class="btn btn-sm btn-outline-light" data-bs-toggle="modal" data-bs-target="#modal-neuro">
                            <i class="fa fa-plus cursor-pointer" ></i>
                        </button>
                    @endcan

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

        <div class="col-lg-12" id="med-card">
            <div class="card h-100 mt-2">
                <!-- BEGIN card-body -->
                <div class="card-header bg-gradient bg-warning-400 d-flex gap-2 align-items-center">

                    <div class="flex-grow-1">
                        <h5 class="mb-1"> Medications</h5>

                    </div>
                    @can('add-medication')
                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modal-medication">
                            <i class="fa fa-plus" ></i>
                        </button>
                    @endcan

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


        <div class="col-lg-12" id="lab-card">
            <div class="card h-100 mt-2">
                <!-- BEGIN card-body -->
                <div class="card-header bg-gradient bg-gray-400 d-flex gap-2 align-items-center">

                    <div class="flex-grow-1">
                        <h5 class="mb-1">Investigations</h5>

                    </div>
                    @can('add-lab-test')
                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modal-lab">
                            <i class="fa fa-plus" ></i>
                        </button>
                    @endcan

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



        <div class="col-lg-12" id="skin-card">
            <div class="card h-100 mt-2">
                <!-- BEGIN card-body -->

                <div class="card-header bg-gradient bg-dark bg-opacity-30 d-flex gap-2 align-items-center">

                    <div class="flex-grow-1">
                        <h5 class="mb-1">Skin and Wound Care</h5>
                    </div>
                    @can('add-skin-care')
                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modal-skin">
                            <i class="fa fa-plus" ></i>
                        </button>
                    @endcan

                    <a href="javascript:;" class="text-secondary"><i class="fa fa-redo"></i></a>
                    <a href="#" data-toggle="card-expand"
                        class="text-white text-opacity-20 text-decoration-none"><i class="fa fa-fw fa-expand"></i></a>

                </div>
                <div class="card-body">
                    <div class="table-responsive" id="table-skin">

                    </div>
                </div>
                <!-- END card-body ya -->
            </div>
        </div>

        <div class="col-lg-12" id="invasive">
            <div class="card h-100 mt-2">
                <!-- BEGIN card-body -->
                <div class="card-header bg-gradient bg-dark bg-opacity-30 d-flex gap-2 align-items-center">

                    <div class="flex-grow-1">
                        <h5 class="mb-1">Invasive Lines</h5>

                    </div>
                    @can('add-invasive-line')
                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modal-invasive">
                            <i class="fa fa-plus" ></i>
                        </button>
                    @endcan

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


        <div class="col-lg-12" id="progress">
            <div class="card h-100 mt-2">
                <!-- BEGIN card-body jkjk-->
                <div class="card-header bg-gradient bg-gray-200 d-flex gap-2 align-items-center">

                    <div class="flex-grow-1">
                        <h5 class="mb-1">Daily Problems/Intervention Record</h5>

                    </div>
                    @can('add-daily-notes')
                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modal-progress">
                            <i class="fa fa-plus" ></i>
                        </button>
                    @endcan

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


        <div class="col-lg-12" id="seizure">
            <div class="card h-100 mt-2">
                <!-- BEGIN card-body -->
                <div class="card-header bg-gradient bg-warning-200 d-flex gap-2 align-items-center">

                    <div class="flex-grow-1">
                        <h5 class="mb-1">Seizure Chart</h5>

                    </div>
                    @can('add-seizure')
                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modal-seizure">
                            <i class="fa fa-plus" ></i>
                        </button>
                    @endcan

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


        <div class="col-lg-12" id="nursing">
            <div class="card h-100 mt-2">
                <!-- BEGIN card-body -->
                <div class="card-header bg-gradient bg-gray-100 d-flex gap-2 align-items-center">

                    <div class="flex-grow-1">
                        <h5 class="mb-1">Nursing Handover Notes </h5>

                    </div>
                    @can('add-daily-notes')
                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modal-daily">
                            <i class="fa fa-plus" ></i>
                        </button>
                    @endcan

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


        <div class="col-lg-12" id="physician">
            <div class="card h-100 mt-2">
                <!-- BEGIN card-body -->
                <div class="card-header bg-gradient bg-warning-500 d-flex gap-2 align-items-center">

                    <div class="flex-grow-1">
                        <h5 class="mb-1">Physician Notes </h5>

                    </div>
                    @can('add-physician-notes')
                        <button class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modal-physician">
                            <i class="fa fa-plus" ></i>
                        </button>
                    @endcan
                    <div class="d-flex align-items-center justify-content-center position-relative bg-body rounded p-2">
                        <i class="fa fa-sticky-note fa-2x"></i>
                        <span
                            class="w-20px h-20px p-0 d-flex align-items-center justify-content-center badge bg-theme text-theme-color position-absolute end-0 top-0 fw-bold fs-12px rounded-pill mt-n1 me-n1"
                            id="phy-notes-count">0</span>
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
@section('outter_content')
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
    <div class="toasts-container">
        <div class="toast fade hide mb-3" data-autohide="true" id="toast-1">
            <div class="toast-header">
                <i class="far fa-bell text-muted me-2"></i>
                <strong class="me-auto">Success</strong>

                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">

            </div>
        </div>

    </div>

@endsection
