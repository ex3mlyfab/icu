@extends('layout.default')

@section('title', 'Home')

@push('css')

@endpush

@push('js')
 let cardioOptions = {
                            chart: {
                                type: 'bar',
                                height: 350
                            },
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
            // console.log(cardioChart, 'cardioChart');
            $(document).ajaxComplete(function() {
                var chartTable = new ApexCharts(document.querySelector('#chartCardio'), cardioOptions);
            chartTable.render();
            })

@endpush

@section('content')

@endsection
