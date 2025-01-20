
{{-- Modal for cardiovascular assessment --}}
<div class="modal fade" id="modal-nutrition" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Nutrition Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="nutrition-form">

                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="patient_care_id" value="{{ $patient->latestPatientCare->id }}">


                    <div class="row">
                        <div class="col-xl-6">
                            <div class="mb-3">
                                <label class="form-label">Select Food <span class="text-danger">*</span></label>
                                <select class="form-select" id="select-nutrition" name="nutrition_select" required>

                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row" id="new-nutrition">
                        <div class="col-md-6 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping1">Food</span>
                                <input type="text" id="nutrition_name" class="form-control" name="nutrition_name"
                                    placeholder="Food Name">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-2">Caloric Intake</span>
                                <input type="text" id="nutrition_dosage" class="form-control" name="caloric_intake"
                                    placeholder="Dosage">

                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <button type="button" class="btn btn-primary" id="nutrition-record-add"><i class="fa fa-plus"></i> Add Nutrition Record</button>
                            <div class="text-danger fs-5" id="nutrition-error"> </div>
                        </div>
                    </div>
                     <div class="table-responsive">
                        <table class="table table-bordered" id="nutrition-record-table">
                            <thead id="nutrition-table-header">
                                <tr>
                                    <th>Nutrition Name</th>
                                    <th>Calorific Intake</th>

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
                    <button type="submit" class="btn btn-primary" id="nutrition-save">
                        <div class="spinner-grow spinner-grow-sm" id="nutrition-save-spinner"></div> Save
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

