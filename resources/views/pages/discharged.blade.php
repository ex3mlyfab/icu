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
                    url: `{{ url('/') }}/show-cardio/{{ $patientCare->id }}/${activeDay}/${viewtype}`,
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
                    url: `{{ URL::to('/') }}/fluid-chart/{{ $patientCare->id }}/${activeDay}`,
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
                    url: `{{ URL::to('/') }}/show/{{ $patientCare->id }}/${activeDay}/${
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
                    url: `{{ URL::to('/') }}/show-patient/{{ $patientCare->id }}/fluid-assessment/${activeDay}/${viewtype}`,
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
                    url: `{{ url('/') }}/show-cardio/{{ $patientCare->id }}/${activeDay}/${viewtype}`,
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
                    url: `{{ URL::to('/') }}/show/{{ $patientCare->id }}/${activeDay}/${
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
                    url: `{{ URL::to('/') }}/show-patient/{{ $patientCare->id }}/medication/${activeDay}/${viewtype}`,
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
                    url: `{{ URL::to('/') }}/show-patient/{{ $patientCare->id }}/nutritions/${activeDay}/${viewtype}`,
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
                    url: `{{ URL::to('/') }}/show-patient/{{ $patientCare->id }}/neuro-assessment/${activeDay}/${viewtype}`,
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
                    url: `{{ URL::to('/') }}/show-patient/{{ $patientCare->id }}/skin-care/${activeDay}/${viewtype}`,
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
                    url: `{{ url('/') }}/show-patient/{{ $patientCare->id }}/dailynotes/${activeDay}/${viewtype}`,
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
                    url: `{{ url('/') }}/show-patient/{{ $patientCare->id }}/renal-fluids/${activeDay}`,
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
                    url: `{{ url('/') }}/show-patient/{{ $patientCare->id }}/daily-treatment/${activeDay}`,
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
                    url: `{{ url('/') }}/show-patient/{{ $patientCare->id }}/physician-order/${activeDay}/${viewtype}`,
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


            //skin form

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
                                    "fw-bold text-gray-emphasis">{{ $patientCare->patient->fullname }}</span>
                        </h4>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <h5 class="text-muted my-0 text-gray-emphasis">Diagnosis: &nbsp;<span
                                class="fw-bold">{{ $patientCare->diagnosis }}</span></h5>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <h5 class="text-muted my-0 text-gray-emphasis"><span class="fw-bold">Next of Kin:
                                &nbsp;</span>{{ $patientCare->patient->next_of_kin }}</h5>
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
