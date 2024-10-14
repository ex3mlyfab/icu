@extends('layout.default')

@section('title', 'Home')

@push('css')
    <link href="{{asset('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
@endpush

@push('js')
    <script src=" {{ asset('assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <script>
        $('#datepicker').datepicker({
            autoclose: true
        });
        // $('#input_patient_id').on('keyup', function() {
        //     if ($(this).val().length > 0  $(this).val().length <= 6) {
        //         $('#search_patient_id').prop('disabled', false);
        //     else {
        //         $('#search_patient_id').prop('disabled', true);
        //     }
        // })
    </script>
@endpush

@section('content')
    <h1 class="page-header">
        Add New Patient
    </h1>
    <div class="card p-3 mt-4">
        <div class="card-body">
            <!-- BEGIN row -->
            <div class="row justify-content-center">
                <div class="card bg-teal bg-opacity-25 mb-4">
                    <div class="card-header bg-none fw-bold justify-content-center">
                        Search Patient from Portal
                    </div>
                    <div class="row card-body">
                        <div class="col-xl-10">
                            <div class="form-group w-full">

                                <input type="text" class="form-control" id="input_patient_id"
                                    placeholder="enter patient hospital no." onkeypress='return event.charCode >= 48 && event.charCode <= 57' >
                            </div>
                        </div>
                        <div class="col-xl-2 d-flex justify-content-center align-items-center">
                            <button type="button" class="btn btn-primary"  id="search_patient_id">Search <i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>

            </div>
           @if ($errors->any())

           @foreach ($errors->all() as $error)
               <div class="alert alert-danger alert-dismissible fade show" role="alert">
                   {{ $error }}
                   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>

           @endforeach

           @endif
            <div class="row">
                <div class="card d-none" id="search_result_details">

                </div>
            </div>
            <!-- END row -->
            <form action="{{ route('patient.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="card mb-4">
                        <div class="row card-body">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name"
                                        placeholder="Enter First Name" name="first_name" value="{{ old('first_name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="middle_name">Middle Name</label>
                                    <input type="text" class="form-control" id="middle_name"
                                        placeholder="Enter middle Name" name="middle_name" value="{{ old('middle_name') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" placeholder="Enter Last Name" name="last_name"
                                        value="{{ old('last_name') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="hospital_no">Hospital Id</label>
                                    <input type="text" class="form-control" id="hospital_no"
                                        placeholder="Enter Hospital Number" onkeypress='return event.charCode >= 48 && event.charCode <= 57' value="{{ old('hospital_no') }}" name="hospital_no" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                <label class="form-label d-block" for="hospital_no">Gender</label>
                                <div class="form-check form-check-inline">

                                    <input class="form-check-input" name="gender" type="radio" value="male"
                                        id="gender_female" >
                                    <label class="form-check-label" for="gender_female">Female</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="gender" type="radio" value="male"
                                        id="gender_male">
                                    <label class="form-check-label" for="gender_male">Male</label>

                                </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="date_of_birth">Date of Birth</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="datepicker"
                                            placeholder="enter date of Birth" name="date_of_birth">
                                        <label class="input-group-text" for="datepicker">
                                            <i class="fa fa-calendar"></i>
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="religion" class="form-label">Select Religion</label>
                                <select class="form-select" id="religion" name="religion" required>
                                    <option selected disabled value="">Choose...</option>
                                    <option value="islam">Islam</option>
                                    <option value="christian">Christianity</option>
                                    <option value="traditional">Traditional Religion</option>
                                </select>
                                @error('religion')
                                    <div class="invalid-feedback">
                                        Please select a valid Religion
                                    </div>
                                @enderror

                            </div>

                            <div class="col-md-4">
                                <label for="marital_status" class="form-label">Select Marital Status</label>
                                <select class="form-select" id="marital_status" name="marital_status" required>
                                    <option selected disabled value="">Choose...</option>
                                    <option value="single">single</option>
                                    <option value="married">married</option>
                                    <option value="widow">widow </option>
                                </select>
                                @error('marital_status')
                                    <div class="invalid-feedback">
                                        Please select a valid Religion
                                    </div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <hr class="mt-2 mb-3">
                    <div class="card bg-theme border-theme bg-opacity-15 mb-4">
                        <div class="row card-body">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="diagnosis">Diagnosis</label>
                                    <input type="text" class="form-control" id="diagnosis" name="diagnosis"
                                        placeholder="Enter diagnosis" value="{{ old('diagnosis') }}">
                                </div>

                            </div>
                            <div class="col-md-4">
                                <label for="condition" class="form-label">Condition</label>
                                <textarea class="form-control" id="condition" name="condition" placeholder="explain a bit of Condition" required></textarea>
                                @error('condition')
                                    <div class="invalid-feedback">
                                        Please enter a conditon for the patient.
                                    </div>
                                @enderror


                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="icu_consultant">Consultant</label>
                                    <input type="text" class="form-control" id="icu_consultant" name="icu_consultant"
                                        placeholder="Enter icu_consultant" value="{{ old('icu_consultant') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="nurse_incharge">Nurse Incharge</label>
                                    <input type="text" class="form-control" id="nurse_incharge" name="nurse_incharge"
                                        placeholder="Enter nurse_incharge" value="{{ old('nurse_incharge') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="admitted_from">Admitted From</label>
                                    <input type="text" class="form-control" id="admitted_from" name="admitted_from"
                                        placeholder="Enter clinic/ward patient came from" value="{{ old('admitted_from') }}">
                                </div>
                            </div>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection
