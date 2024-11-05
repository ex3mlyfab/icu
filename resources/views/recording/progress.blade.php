
{{-- Modal for progressvascular assessment --}}
<div class="modal fade" id="modal-progress" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Record New Progress Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id=
            "progress-form">

                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="patient_care_id" value="{{$patient->latestPatientCare->id}}" >

                    <div class="row">
                        <div class="small text-inverse text-opacity-50 mb-2"><b class="fw-bold">Duty</b></div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group mb-4 d-flex flex-column justify-content-end">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="daily-note-day" name="duty"
                                        value="1morning">
                                    <label class="form-check-label" for="daily" id="dailyLabel">Morning</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="daily-note-night" name="duty"
                                        value="night" checked>
                                    <label class="form-check-label" for="daily" id="dailyLabel">Night</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                                <label for="contents">Handover Summary</label>
                                <textarea name="text" class="form-control summernote" id="contents" title="Contents"></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="progress-save"><div class="spinner-grow spinner-grow-sm" id="progress-save-spinner"></div> Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

