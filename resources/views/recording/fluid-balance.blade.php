{{-- Modal for cardiovascular assessment --}}
<div class="modal fade" id="modal-fluid" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-gradient bg-warning">
                <h5 class="modal-title">Add Fluid Recording</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="fluid-form">

                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="patient_care_id" value="{{$patient->latestPatientCare->id }}">

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label class="form-label">Select Fluid <span class="text-danger">*</span></label>
                                <select class="selectpicker form-control" id="ex-search" name="fluid_select">
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
                    <div class="row" id="new-fluid">
                        <div class="col-md-6 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping1">Fluid Name</span>
                                <input type="text" id="fluid_name" class="form-control" name="fluid_name"
                                    placeholder="Fluid Name" required>

                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-2">Direction</span>
                                <select class="form-select form-select-sm">
                                    <option selected>Select Direction</option>
                                    <option value="input">Intake</option>
                                    <option value="output">Output</option>
								</select>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">Volume(ml)</span>
                                <input type="number" class="form-control" name="blood_pressure_diastolic"
                                    placeholder="Bp-Diastolic" required>

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="input-group bootstrap-timepicker timepicker">
                                <span class="input-group-text" id="addon-wrapping">Hour Recorded</span>
                                <input id="timepicker-default" type="text" class="form-control"
                                    name="hour_taken">
                                <span class="input-group-addon input-group-text">
                                    <i class="fa fa-clock"></i>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="fluid-save">
                        <div class="spinner-grow spinner-grow-sm" id="fluid-save-spinner"></div> Save
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
