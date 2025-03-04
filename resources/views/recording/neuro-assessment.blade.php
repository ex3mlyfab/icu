
{{-- Modal for neurovascular assessment --}}
<div class="modal fade" id="modal-neuro" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient bg-danger">
                <h5 class="modal-title">Add New Neurological assessment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="neuro-form">

                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="patient_care_id" value="{{$patient->latestPatientCare->id}}" >

                    <div class="row gx-2 align-items-center border rounded p-2">
                        <div class="col-md-12 col-lg-4 mb-3 ">
                            <div class="form-group mb-3">
                                    <label class="form-label d-block fw-bold">Eyes Open</label>
                                    @foreach (\App\Enums\EyesOpenEnum::cases() as $eyeOpen)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="{{$eyeOpen->value}}" id="defaultRadio-{{$eyeOpen->value}}" name="eyes_open" required>
                                        <label class="form-check-label" for="defaultRadio-eyes{{$eyeOpen->value}}">{{$eyeOpen->name}}</label>
                                    </div>
                                    @endforeach

                            </div>
                            <hr>
                            <div class="form-group row">
                                <label class="form-label col-md-5 d-block fw-bolder">Sedated</label>
                                <div class="col-md-7">
                                <div class="form-check">
                                        <input class="form-check-input" type="radio" value="1" id="defaultRadio-sedated" name="sedated" required>
                                        <label class="form-check-label" for="defaultRadio-sedated">Yes</label>
                                </div>
                                <div class="form-check">
                                        <input class="form-check-input" type="radio" value="0" id="defaultRadio-sedated_no" name="sedated" required >
                                        <label class="form-check-label" for="defaultRadio-sedated_no">No</label>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4 mb-3 border-start ps-1">
                           <div class="form-group ">
                                    <label class="form-label d-block fw-bold">Best Verbal Response</label>
                                    @foreach (\App\Enums\VerbalResponseEnum::cases() as $verbalResponse)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="{{$verbalResponse->value}}" id="defaultRadio-verbal{{$verbalResponse->value }}" name="best_verbal_response" required>
                                        <label class="form-check-label" for="defaultRadio-verbal{{$verbalResponse->value}}">{{$verbalResponse->name}}</label>
                                        </div>
                                    @endforeach
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label class="form-label col-md-5 d-block fw-bolder">Intubated</label>
                                <div class="col-md-7">
                                <div class="form-check">
                                        <input class="form-check-input" type="radio" value="1" id="defaultRadio-intubated" name="intubated" required>
                                        <label class="form-check-label" for="defaultRadio-intubated">Yes</label>
                                </div>
                                <div class="form-check">
                                        <input class="form-check-input" type="radio" value="0" id="defaultRadio-intubated_no" name="intubated" required>
                                        <label class="form-check-label" for="defaultRadio-intubated_no">No</label>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4 mb-3 border-start ps-1">
                            <div class="form-group mb-3 ">
                                    <label class="form-label d-block fw-bold">Best Motor Response</label>
                                    @foreach (\App\Enums\MotorResponseEnum::cases() as $motor)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="{{$motor->value}}" id="defaultRadio-motor{{$motor->value }}" name="best_motor_response" required>
                                        <label class="form-check-label" for="defaultRadio{{$motor->value}}">{{$motor->name}}</label>
                                        </div>
                                    @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center  border rounded ps-2">

                        <div class="col-md-12 col-lg-4 mb-3 border-start pl-2">
                            <div class="form-group mb-3 rounded">
                                    <label class="form-label d-block fw-bold">Sedation Score(Ramsey)</label>
                                    @foreach (\App\Enums\SedationScoreEnum::cases() as $sedation)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="{{$sedation->value}}" id="defaultRadio{{$sedation->value }}" name="sedation_score">
                                        <label class="form-check-label" for="defaultRadio{{$sedation->value}}">{{$sedation->name}}</label>
                                        </div>
                                    @endforeach
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4 mb-3 pl-2 border-start">
                            <div class="form-group mb-3 rounded">

                                <label class="form-label">Pupil Diameter <span class="text-danger">*</span></label>
													<div>
														<input id="pupil-diameter" class="form-range" type="range" value="1"
                                                        min="1" max="6" name="pupil_diameter" required/>
													</div>
                                                    <span class="range-indicator" id="value-pupil-diameter"></span>
                            </div>
                        </div>

                    </div>
                    <div class="row mt-2">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="neuro-save"><div class="spinner-grow spinner-grow-sm" id="neuro-save-spinner"></div> Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

