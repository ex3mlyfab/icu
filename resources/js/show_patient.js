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
                    text: 'CardioVascular Assessment Chart',
                },
                noData: {
                    text: 'Loading...'
                }
            }
            var cardioCharting = new ApexCharts(document.querySelector("#chartCardio"), cardioOptions);
            cardioCharting.render();
            //respiratory Chart
            var respiratoryChart= {};
            var respiratoryOptions = {
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
                        enabled: false,
                    },
                series: [],
                title: {
                    text: 'Respiratory Assessment Chart',
                },
                noData: {
                    text: 'Loading...'
                }
            }
            var respiratoryCharting = new ApexCharts(document.querySelector("#chartRespiratory"), respiratoryOptions);
            respiratoryCharting.render();
               //fluid Chart
            var fluidChart= {};
            var fluidOptions = {
                chart: {
                    type: 'bar',
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
                        enabled: false,
                    },
                series: [],
                title: {
                    text: 'Fluid Assessment Chart',
                },                noData: {
                    text: 'Loading...'
                }
            }
            var fluidCharting = new ApexCharts(document.querySelector("#chartFluid"), fluidOptions);
            fluidCharting.render();

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
                        console.log(data.direction.input, "from input");
                        // console.log()
                        var table = $('<table class="table table-bordered"></table>');
                        var headerIndicator = $('<thead></thead>');
                        // Create a table header row
                        fluidChart.label = fluidData.label
                        var headerRow = $('<tr></tr>');
                        headerRow.append('<th class="bg-yellow-300">label</th>');
                        for (var i = 0; i < fluidData.label.length; i++) {

                            headerRow.append('<th>' + fluidData.label[i] + '</th>');
                        }
                        headerIndicator.append(headerRow);
                        table.append(headerIndicator);
                        table.append(`<tr id="fluidIntake">
                            <td colspan="${fluidData.label.length}" class="text-center bg-gradient bg-danger text-white fw-bold">Intake
                            </tr><tr id="fluidOutput">
                            <td colspan="${fluidData.label.length}" class="text-center bg-gradient bg-danger text-white fw-bold">Output
                            </tr>`);

                        // Create table body rows
                        for (var key in fluidData) {
                            if (key !== "label" && key !== 'Direction') {
                                let fluidArray = [];
                                var row = $('<tr></tr>');
                                row.append('<th class="bg-yellow-300 ps-1">' + key + '</th>');
                                for (var i = 0; i < fluidData[key].length; i++) {

                                    row.append('<td class="text-center">' + fluidData[key][i] + '</td>');
                                    fluidArray.push(~~fluidData[key][i]);
                                }
                                table.append(row);
                                fluidChart[key] = fluidArray
                            }
                        }
                        let fluiSeriesArray = [];
                        for (var key in fluidData) {
                            if (key !== "label" && key !== 'Direction') {
                                fluiSeriesArray.push({
                                    name: key,
                                    data: fluidData[key]
                                })
                            }
                        }
                        fluidChart.series = fluiSeriesArray
                        let fluidOptions = {
                            series: fluiSeriesArray,
                            xaxis: {
                                categories: fluidChart.label
                            },
                        }
                        fluidCharting.updateOptions(fluidOptions, true);

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
                    url:`{{url('/')}}/show-cardio/{{ $patient->latestPatientCare->id }}/${activeDay}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {

                        let myData = data.data;
                        if ($.isEmptyObject(myData)) {

                            $("#table-cardio").html('<h2 class="text-center">No data</h2>');

                        }else{

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
                                    row.append('<td class="text-center">' + myData[key][i] + '</td>');
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
                    url: `{{ URL::to('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/resp-assessment/${activeDay}`,
                    dataType: 'json', // Specify the expected data format (e.g., JSON)
                    success: function(data) {


                        // $('#chart-3').html(data.data);
                        let respData = data.data;
                        var table = $('<table class="table table-bordered"></table>');
                        var headerIndicator = $('<thead></thead>');
                        // Create a table header row
                        var headerRow = $('<tr></tr>');
                        respiratoryChart.label = respData.label
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
                                let respArray = [];
                                row.append('<th class="bg-dark-300 ps-2 text-white">' + key + '</th>');
                                for (var i = 0; i < respData[key].length; i++) {

                                    row.append('<td class="text-center">' + respData[key][i] + '</td>');
                                    respArray.push(~~respData[key][i]);
                                }
                                table.append(row);
                                respiratoryChart[key] = respArray
                            }
                        }

                           let respOptions = {
                            series: [
                                {
                                    name: "FiO2",
                                    data:respiratoryChart["FiO2"]
                                },
                                {
                                    name:"Respiratory Effort",
                                    data: respiratoryChart["Respiratory Effort"]
                                }
                            ],
                            xaxis: {
                                categories: respiratoryChart.label
                            },
                        }
                        respiratoryCharting.updateOptions(respOptions, true);
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
                    url: `{{ URL::to('/') }}/show-patient/{{ $patient->latestPatientCare->id }}/skin-care/${activeDay}`,
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
                $.ajax({
                    type: 'GET', // or 'POST' if required
                    url: `{{url('/')}}/show-patient/{{ $patient->latestPatientCare->id }}/renal-fluids/${activeDay}`,
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
                    url: `{{url('/')}}/show-patient/{{ $patient->latestPatientCare->id }}/daily-treatment/${activeDay}`,
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
                    url: `{{url('/')}}/show-patient/{{ $patient->latestPatientCare->id }}/physician-order/${activeDay}`,
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
