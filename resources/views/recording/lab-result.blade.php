
{{-- Modal for lab test --}}
<div class="modal fade" id="modal-lab" data-bs-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-teal-600">
                <h5 class="modal-title">Add New Lab Test Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="lab-form">

                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="patient_care_id" value="{{$patient->latestPatientCare->id}}" >

                    <div class="row">
                        <div class="small text-inverse text-opacity-50 mb-2"><b class="fw-bold">Select Investigation Type</b></div>
                        <div class="col-md-6">

                            <div class="form-group mb-4 d-flex flex-column justify-content-end">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Lab" id="defaultLabTest" name="lab_test[]" checked>
                                    <label class="form-check-label" for="defaultLabTest">Lab</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="lab_test[]" value="X-Ray" id="defaultXray" >
                                    <label class="form-check-label" for="defaultXray">X-Ray</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"  name="lab_test[]" value="Doppler Scan" id="defaultusound" >
                                    <label class="form-check-label" for="defaultusound">Ultra Sound</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"  name="lab_test[]" value="MRI" id="defaultmri" >
                                    <label class="form-check-label" for="defaultmri">MRI</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"  name="lab_test[]" value="Dialyses" id="defaultDialyses" >
                                    <label class="form-check-label" for="defaultDialyses">Dialyses</label>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"  name="lab_test[]" value="ECG" id="defaultecg" >
                                    <label class="form-check-label" for="defaultecg">ECG</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"  name="lab_test[]" value="ct scan" id="defaultct-scan" >
                                    <label class="form-check-label" for="defaultct-scan">CT SCAN</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"  name="lab_test[]" value="Echo" id="defaultecho" >
                                    <label class="form-check-label" for="defaultecho">ECHO</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"  name="lab_test[]" value="Doppler Scan" id="defaultdoppler" >
                                    <label class="form-check-label" for="defaultdoppler">Doppler Scan</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"  name="lab_test[]" value="others" id="defaultothers" >
                                    <label class="form-check-label" for="defaultothers">Others</label>
                                </div>
                            </div>

                        </div>
                    </div>
                     <div class="row" id="new-lab">
                        <div class="col-md-6 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping1">Test Name</span>
                                <input type="text" id="test_name" class="form-control" name="lab_test[]"
                                    placeholder="Test Name">

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="lab-save"><div class="spinner-grow spinner-grow-sm" id="lab-save-spinner"></div> Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

