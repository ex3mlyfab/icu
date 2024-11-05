
{{-- Modal for physicianvascular assessment --}}
<div class="modal fade" id="modal-physician" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Record New Physician Mote</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="physician-form">

                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="patient_care_id" value="{{$patient->latestPatientCare->id}}" >

                    <div class="row">
                        <
                        <div class="col-md-12">
                                <label for="contents">Medical Note</label>
                                <textarea name="text" class="form-control summernote" id="contents" title="Contents"></textarea>
                        </div>



                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="physician-save"><div class="spinner-grow spinner-grow-sm" id="physician-save-spinner"></div> Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

