@extends('layout.default')

@section('title', 'Home')

@push('css')
@endpush
@push('js')
@endpush

@section('content')
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

        </div>
        <div class="col-md-3 border-start border-2 border-primary">

            <h5 class="text-muted my-0 text-gray-emphasis"><span class="fw-bold">Next of Kin:
                    &nbsp;</span>{{ $patient->next_of_kin }}</h5>
        </div>
        <div class="col-md-3 border-start border-2 border-primary">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">DashBoard</a>



        </div>
    </div>

    <div class="card mt-3">
        <div class="card-title">
            Admission History
        </div>
        <div class="card-body">
            <div class="table-responsive ">
            <table  class="table text-nowrap w-100 table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Bed</th>
                        <th>Admission Date</th>
                        <th>Discharge Date</th>
                        <th>Diagnosis</th>
                        <th>Condition</th>
                        <th>Admitted From</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patient->patientCares as $patientCare)
                        <tr>
                            <td>{{ $patientCare->bedModel->name }}</td>
                            <td>{{ $patientCare->admission_date->format('d/M/Y') }}</td>
                            <td>{{ $patientCare->discharge_date ? $patientCare->discharge_date->format('d/M/Y') : 'On Admission'  }}</td>
                            <td>{{ $patientCare->diagnosis }}</td>
                            <td>{{ $patientCare->notes }}</td>
                            <td>{{ $patientCare->admitted_from }}</td>
                            <td>{{$patientCare->notes}}</td>
                            <td> <a href="{{ ($patientCare->discharge_date != null ?  route('patient_view.discharged',$patientCare): route('patient.treatment',$patient) )}}" class="btn btn-outline-info">View Admission Details</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
@endsection
