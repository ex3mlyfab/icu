{{-- Modal for skinvascular assessment --}}
<div class="modal fade" id="modal-skin" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Record Skin And Wound Care</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="skin-form">

                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="patient_id_care"
                    value="{{$patient->latestPatientCare->id }}">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-skin">Skin Integrity</span>
                                <input type="text" id="skin-integrity" class="form-control" name="skin_integrity"
                                    placeholder="skin integrity">

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-drain">Drain Output</span>
                                <input type="text" id="drain-output" class="form-control" name="drain_output"
                                    placeholder="drain output">

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-dressing">Wound Dressing</span>
                                <input type="text" id="wound-dressing" class="form-control" name="wound_dressings"
                                    placeholder="wound dressing">

                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="skin-save">
                        <div class="spinner-grow spinner-grow-sm" id="skin-save-spinner"></div> Save
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
