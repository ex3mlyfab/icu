
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
                    <div id="fluid-add">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="mb-3" >
                                    <label class="form-label">Select Fluid <span class="text-danger">*</span></label>
                                    <select class="form-select" id="select-fluid" name="fluid_select">

                                    </select>

                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row" id="new-fluid">
                            <div class="col-md-6 mb-3">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrappingFluid">Fluid Name</span>
                                    <input type="text" id="fluid-type-name" class="form-control fluid-name" name="fluid_name"
                                    placeholder="Fluid Name">

                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-2Fluid">Direction</span>
                                    <select class="form-select form-select-sm fluid-direction" name="direction" id="fluid-type-direction">
                                        <option selected>Select Direction</option>
                                        <option value="input">Input</option>
                                        <option value="output">Output</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">Volume(ml)</span>
                                <input type="number" class="form-control" name="volume"
                                    placeholder="Volume" id="fluid-volume">

                            </div>
                        </div>
                        <div class="col-md-6">
                            
                            <button type="button" class="btn btn-primary" id="fluid-record-add"><i class="fa fa-plus"></i> Add Fluid Record</button>
                            <div class="text-danger fs-5" id="fluid-error"> Select all fluid name, direction and Volume </div>


                        </div>



                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="fluid-record-table">
                            <thead id="fluid-table-header">
                                <tr>
                                    <th>Fluid Name</th>
                                    <th>Volume(ml)</th>
                                    <th>Direction</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
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
