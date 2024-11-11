{{-- Modal for lab test --}}
<div class="modal fade" id="modal-result" data-bs-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-teal-600">
                <h5 class="modal-title">Mark Result As Recieved</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="collect-result-form">

                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="patient_care_id" value="{{ $patient->latestPatientCare->id }}">

                    <div class="row">
                        <div class="small text-inverse text-opacity-50 mb-2"><b class="fw-bold">Inestigation Info</b>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group mb-4 d-flex flex-column justify-content-end">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="collectResult" name="lab_id"
                                        checked>
                                    <label class="form-check-label" for="collectResult" id="collectResultLabel"></label>
                                </div>


                            </div>
                        </div>


                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="collect-result-save">
                        <div class="spinner-grow spinner-grow-sm" id="collect-result-save-spinner"></div> Save
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
