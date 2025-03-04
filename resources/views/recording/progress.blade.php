
{{-- Modal for progressvascular assessment --}}
<div class="modal fade" id="modal-progress" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Record New Progress Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="progress-form">

                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="patient_care_id" value="{{$patient->latestPatientCare->id}}" >

                    <div class="row">

                        <div class="col-md-12">
                                <label for="contents">Problems</label>
                                <textarea name="content" class="form-control summernote" id="contents" title="Contents"></textarea>
                        </div>
                        <div class="col-md-12">
                                <label for="intervention">Intervention</label>
                                <textarea name="intervention" class="form-control summernote" id="intervention" title="Intervention"></textarea>
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

