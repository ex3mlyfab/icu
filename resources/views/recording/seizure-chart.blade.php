
{{-- Modal for cardiovascular assessment --}}
<div class="modal fade" id="modal-seizure" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title">Record New Seizure Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="seizure-form">

                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="patient_care_id" value="{{$patient->latestPatientCare->id}}" >

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrappingseizure">Description</span>
                                <input type="text" id="seizure" class="form-control" name="description"
                                    placeholder="Descritption" required>

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-intervention">Intervention</span>
                                <input type="text" class="form-control" name="intervention"
                                    placeholder="Intervention" required>

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping-duration">Duration</span>
                                <input type="text" class="form-control" name="durations"
                                    placeholder="Duration" required>

                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="input-group bootstrap-timepicker timepicker">
                                <span class="input-group-text" id="addon-wrapping-time">Time Recorded</span>
                                <input id="timepicker-default-seizure" type="text" class="form-control  timepickerAcross" name="hour_taken">
                                <span class="input-group-addon input-group-text">
                                    <i class="fa fa-clock"></i>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="seizure-save"><div class="spinner-grow spinner-grow-sm" id="seizure-save-spinner"></div> Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

