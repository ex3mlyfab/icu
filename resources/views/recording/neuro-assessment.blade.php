
{{-- Modal for cardiovascular assessment --}}
<div class="modal fade" id="modal-neuro" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-gradient bg-danger">
                <h5 class="modal-title">Add New Neurological assessment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="cardio-form">

                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="patient_care_id" value="{{$patient->latestPatientCare->id}}" >

                    <div class="row gx-2 align-items-center mx-3">
                        <div class="col-md-6 mb-3 border rounded">
                            <div class="form-group mb-3">
                                    <label class="form-label d-block fw-bold">Eyes Open</label>
                                    @foreach (\App\Enums\EyesOpenEnum::cases() as $eyeOpen)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="{{$eyeOpen->value}}" id="defaultRadio{{$eyeOpen->value }}" name="eyes_open">
                                        <label class="form-check-label" for="defaultRadio{{$eyeOpen->value}}">{{$eyeOpen->name}}</label>
                                        </div>
                                    @endforeach
                                    {{-- <input type="radio" name="sedated" id="sedated" value="sedated"> --}}
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 border rounded">
                           <div class="form-group mb-3">
                                    <label class="form-label d-block fw-bold">Best Verbal Response</label>
                                    @foreach (\App\Enums\VerbalResponseEnum::cases() as $verbalResponse)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="{{$verbalResponse->value}}" id="defaultRadio{{$verbalResponse->value }}" name="best_verbal_response">
                                        <label class="form-check-label" for="defaultRadio{{$verbalResponse->value}}">{{$verbalResponse->name}}</label>
                                        </div>
                                    @endforeach
                            </div>
                        </div>
                        <div class="col-md-6 mb-3 border rounded">
                            <div class="form-group mb-3 ">
                                    <label class="form-label d-block fw-bold">Best Motor Response</label>
                                    @foreach (\App\Enums\MotorResponseEnum::cases() as $motor)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="{{$motor->value}}" id="defaultRadio{{$motor->value }}" name="best_motor_response">
                                        <label class="form-check-label" for="defaultRadio{{$motor->value}}">{{$motor->name}}</label>
                                        </div>
                                    @endforeach
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group mb-3">
                                    <label class="form-label d-block">Sedation Score(Ramsey)</label>
                                    @foreach (\App\Enums\SedationScoreEnum::cases() as $sedation)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="{{$sedation->value}}" id="defaultRadio{{$sedation->value }}" name="best_sedation_response">
                                        <label class="form-check-label" for="defaultRadio{{$sedation->value}}">{{$sedation->name}}</label>
                                        </div>
                                    @endforeach
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="cardio-save"><div class="spinner-grow spinner-grow-sm" id="cardio-save-spinner"></div> Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

