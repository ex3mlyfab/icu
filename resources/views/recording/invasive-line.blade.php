
{{-- Modal for invasivevascular assessment --}}
<div class="modal fade" id="modal-invasive" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title">Record Invasive Line</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="invasive-form">

                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="patient_care_id" value="{{$patient->latestPatientCare->id}}" >

                    <div class="row">
                         <div class="col-md-12 mb-3">
                                <label for="invasive_lines" class="form-label">Select invasive_lines</label>
                                <select class="form-select" id="invasive_lines" name="invasive_lines" required>
                                    <option selected disabled value="">Choose...</option>
                                    <option value="Central Veinous Catheter">Central Veinous Catheter</option>
                                    <option value="Arterial Lines">Arterial Lines</option>
                                    <option value="Chest Tubes">Chest Tubes </option>
                                    <option value="Drainage Tubes">Drainage Tubes </option>
                                    <option value="Others">Others</option>
                                </select>
                                @error('invasive_lines')
                                    <div class="invalid-feedback">
                                        Please select a valid invasive lines
                                    </div>
                                @enderror

                            </div>
                        <div class="col-md-12 mb-3">
                            <div class="input-group bootstrap-timepicker timepicker">
                                <span class="input-group-text" id="addon-wrapping">Hour Recorded</span>
                                <input id="timepicker-default-invasive" type="text" class="form-control timepickerAcross" name="hour_taken">
                                <span class="input-group-addon input-group-text">
                                    <i class="fa fa-clock"></i>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="invasive-save"><div class="spinner-grow spinner-grow-sm" id="invasive-save-spinner"></div> Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

