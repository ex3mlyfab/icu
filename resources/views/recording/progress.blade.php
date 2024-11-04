
{{-- Modal for cardiovascular assessment --}}
<div class="modal fade" id="modal-progress" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Record New Progress Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="cardio-form">

                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="patient_care_id" value="{{$patient->latestPatientCare->id}}" >

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping1">Heart-Rate</span>
                                <input type="number" id="heart_rate" class="form-control" name="heart_rate"
                                    placeholder="heart-rate" required>

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-2">BP-Systolic</span>
                                <input type="number" class="form-control" name="blood_pressure_systolic"
                                    placeholder="Bp-sytolic" required>

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">BP-Diastolic</span>
                                <input type="number" class="form-control" name="blood_pressure_diastolic"
                                    placeholder="Bp-Diastolic" required>

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">Temperature <sup>0</sup>C</span>
                                <input type="number" class="form-control" name="temperature" placeholder="temperature">

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">Respiratory Rate</span>
                                <input type="number" class="form-control" name="respiratory_rate"
                                    placeholder="Respiratory Rate">

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">SPO<sub>2</sub></span>
                                <input type="number" class="form-control" name="weight" placeholder="Weight">

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">MAP</span>
                                <input type="number" class="form-control" name="map" placeholder="MAP">

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">CVP</span>
                                <input type="number" class="form-control" name="cvp" placeholder="CVP">

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">Rhythm</span>
                                <input type="number" class="form-control" name="rhythm" placeholder="rhythm">

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">Peripheral Pulses</span>
                                <input type="number" class="form-control" name="peripheral_pulses"
                                    placeholder="peripheral_pulses">

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">Capillary Refill Time</span>
                                <input type="number" class="form-control" name="capillary_refill_time"
                                    placeholder="capillary_refill_time">

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group bootstrap-timepicker timepicker">
                                <span class="input-group-text" id="addon-wrapping">Hour Recorded</span>
                                <input id="timepicker-default" type="text" class="form-control" name="hour_taken">
                                <span class="input-group-addon input-group-text">
                                    <i class="fa fa-clock"></i>
                                </span>
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

