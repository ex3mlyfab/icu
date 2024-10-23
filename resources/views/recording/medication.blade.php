
{{-- Modal for medicationvascular assessment --}}
<div class="modal fade" id="modal-medication" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-gradient bg-warning-400">
                <h5 class="modal-title">Add New Medication Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="medication-form">

                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="patient_care_id" value="{{$patient->latestPatientCare->id}}" >

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label class="form-label">Select Drug <span class="text-danger">*</span></label>
                                <select class="selectpicker form-control select-search" id="ex-drug-search" name="drug_select">
                                    <option value="1">Mustard</option>
                                    <option value="2">Ketchup</option>
                                    <option value="3">Relish</option>
                                    <option value="4">Tent</option>
                                    <option value="5">Flashlight</option>
                                    <option value="6">Toilet Paper</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row" id="new-drug">
                        <div class="col-md-4 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping1">Drug Name</span>
                                <input type="text" id="medication_name" class="form-control" name="medication_name"
                                    placeholder="Medication Name" required>

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-2">Dosage</span>
                                <select class="form-select form-select-sm">
                                    <option selected>Select Dosage</option>
                                    <option value="input">Intake</option>
                                    <option value="output">Output</option>
								</select>

                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-2">frequency</span>
                                <select class="form-select form-select-sm">
                                    <option selected>Select Dosage</option>
                                    <option value="input">Intake</option>
                                    <option value="output">Output</option>
								</select>

                            </div>
                        </div>
                    </div>
                    <hr />
                     <div class="col-md-6 mb-3">
                            <div class="input-group bootstrap-timepicker timepicker">
                                <span class="input-group-text" id="addon-wrapping">Hour Recorded</span>
                                <input id="timepicker-default" type="text" class="form-control" name="hour_taken">
                                <span class="input-group-addon input-group-text">
                                    <i class="fa fa-clock"></i>
                                </span>
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="medication-save"><div class="spinner-grow spinner-grow-sm" id="medication-save-spinner"></div> Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

