@extends('layout.default')

@section('title', 'Home')

@push('css')
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endpush

@push('js')
    <script src=" {{ asset('assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $('#datepicker').datepicker({
            autoclose: true,
            orientation: "bottom"
        });
        $('#admission_date').datepicker({
            autoclose:true,
            todayHighlight: true,
        });
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-1">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h1>Add New Patient Information</h1>
                    <a href="{{route('dashboard')}}" class="btn btn-primary">DashBoard</a>
                </div>

            </div>
        </div>
    </div>
    <div class="card p-3 mt-4">
        <div class="card-body">
            <!-- BEGIN row -->

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
                                        placeholder="Enter First Name" name="first_name" value="{{ old('first_name') }}"
                                        required>
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
                                    <input type="text" class="form-control" id="last_name" placeholder="Enter Last Name"
                                        name="last_name" value="{{ old('last_name') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="address">Address</label>
                                    <input type="text" class="form-control" id="address"
                                        placeholder="Enter Address"
                                        value="{{ old('address') }}" name="address" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label d-block" for="hospital_no">Gender</label>
                                    @foreach (\App\Enums\GenderEnum::cases() as $key=> $item)
                                    <div class="form-check form-check-inline">

                                        <input class="form-check-input" name="gender" type="radio" value="{{$item->value}}"
                                            id="gender_{{$key}}" @selected(old('gender')== $item->value)>
                                        <label class="form-check-label" for="gender_{{$key}}">{{$item->name}}</label>
                                    </div>

                                    @endforeach

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="date_of_birth">Date of Birth</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="datepicker"
                                            placeholder="enter date of Birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
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
                                    @foreach (\App\Enums\MaritalStatusEnum::cases() as $marital_status)
                                    <option value="{{$marital_status->value}}" @selected(old('marital_status')== $marital_status->value)>{{$marital_status->name}}</option>

                                    @endforeach
                                </select>
                                @error('marital_status')
                                    <div class="invalid-feedback">
                                        Please select a valid Religion
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="tribe">Ethnic Group</label>
                                    <input type="text" class="form-control" id="tribe"
                                        placeholder="Enter Patient Ethnic Group" value="{{ old('tribe') }}"
                                        name="tribe" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="occupation">occupation</label>
                                    <input type="text" class="form-control" id="occupation"
                                        placeholder="Enter Occupation" value="{{ old('occupation') }}" name="occupation">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="hometown">Home Town</label>
                                    <input type="text" class="form-control" id="hometown"
                                        placeholder="Enter hometown" value="{{ old('hometown') }}" name="hometown">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="state_of_origin">State of Origin</label>
                                    <input type="text" class="form-control" id="state_of_origin"
                                        placeholder="Enter stat_of_origin" value="{{ old('state_of_origin') }}"
                                        name="state_of_origin">
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="telephone">Telephone</label>
                                    <input type="text" class="form-control" id="telephone"
                                        placeholder="Enter telephone" value="{{ old('telephone') }}" name="telephone">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="next_of_kin">Next of Kin</label>
                                    <input type="text" class="form-control" id="next_of_kin"
                                        placeholder="Enter next_of_kin" value="{{ old('next_of_kin') }}"
                                        name="next_of_kin">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="next_of_kin_address">Next of Kin Address</label>
                                    <input type="text" class="form-control" id="next_of_kin_address"
                                        placeholder="Enter next_of_kin_address" value="{{ old('next_of_kin_address') }}"
                                        name="next_of_kin_address">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="next_of_kin_telephone">Next of Kin Telephone</label>
                                    <input type="text" class="form-control" id="next_of_kin_telephone"
                                        placeholder="Enter next_of_kin_telephone"
                                        value="{{ old('next_of_kin_telephone') }}" name="next_of_kin_telephone">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="next_of_kin_relationship">Next of Kin
                                        Relationship</label>
                                    <input type="text" class="form-control" id="next_of_kin_relationship"
                                        placeholder="Enter next_of_kin_relationship"
                                        value="{{ old('next_of_kin_relationship') }}" name="next_of_kin_relationship">
                                </div>
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
                                <textarea class="form-control" id="condition" name="condition" placeholder="explain a bit of Condition" value="{{ old('condition') }}" required></textarea>
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
                                        placeholder="Enter clinic/ward patient came from"
                                        value="{{ old('admitted_from') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="admission_date">Date of Admission</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="admission_date"
                                            placeholder="enter date of Admission" name="admission_date" value="{{ old('admission_date') }}">
                                        <label class="input-group-text" for="admission_date">
                                            <i class="fa fa-calendar"></i>
                                        </label>
                                    </div>

                                </div>
                            </div>
                           <div class="col-md-4">
                                <label for="bed_mode_id" class="form-label">Select Bed</label>
                                <select class="form-select" id="bed_mode_id" name="bed_model_id" required>
                                    <option selected disabled value="">Choose...</option>
                                    @foreach ($available_bed as $item)
                                        <option value="{{$item->id}}"> {{$item->section. '- '.$item->name}}
                                    @endforeach

                                </select>
                                @error('bed_mode_id')
                                    <div class="invalid-feedback">
                                        Please select a valid BedCode
                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection
