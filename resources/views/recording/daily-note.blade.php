
{{-- Modal for cardiovascular assessment --}}
<div class="modal fade" id="modal-daily" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
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
                        <div class="small text-inverse text-opacity-50 mb-2"><b class="fw-bold">Handover Notes</b></div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group mb-4 d-flex flex-column justify-content-end">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"  id="daily-note-day" name="duty" value="1morning">
                                    <label class="form-check-label" for="cardio" id="cardioLabel">Morning</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"  id="daily-note-night" name="duty" value="night" checked>
                                    <label class="form-check-label" for="cardio" id="cardioLabel">Night</label>
                                </div>
                        </div>
                        <div class="col-md-12">
                            
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

