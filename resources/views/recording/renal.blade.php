
{{-- Modal for cardiovascular assessment --}}
<div class="modal fade" id="modal-renal" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Cardiovasular assessment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="cardio-form">

                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="patient_care_id" value="{{$patient->latestPatientCare->id}}" >

                    <div class="row">

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
                            <div class="input-group bootstrap-timepicker timepicker">
                                <span class="input-group-text" id="addon-wrapping-renal">Hour Recorded</span>
                                <input id="timepicker-default-renal" type="text" class="form-control  timepickerAcross" name="hour_taken">
                                <span class="input-group-addon input-group-text">
                                    <i class="fa fa-clock"></i>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="renal-save"><div class="spinner-grow spinner-grow-sm" id="renal-save-spinner"></div> Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

