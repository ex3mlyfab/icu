
{{-- Modal for dischargevascular assessment --}}
<div class="modal fade" id="modal-discharge" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Prepare patient for Discharge</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="discharge-form">

                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="patient_care_id" value="{{$patient->latestPatientCare->id}}" >

                    <div class="row">
                        <div class="small text-inverse text-opacity-50 mb-2"><b class="fw-bold">Discharge Type</b></div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group mb-4 d-flex flex-column justify-content-end">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="discharge-normal" name="discharge"
                                        value="Discharged">
                                    <label class="form-check-label" for="daily" id="dailyLabel">Discharge</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="discharge-CAMA" name="discharge"
                                        value="Discharge Against Medical Advice">
                                    <label class="form-check-label" for="discharge-CAMA" id="dailyLabel">Patient Discharge Against Medical Advice</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="discharge-death" name="discharge"
                                        value="Death">
                                    <label class="form-check-label" for="daily" id="discharge-death">Death of Patient</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="discharge-lama" name="discharge"
                                        value="Left Against Medical Advice">
                                    <label class="form-check-label" for="discharge-lama" id="dailyLabel">Morning</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="discharge-request" name="discharge"
                                        value="Discharge on Patient Request" checked>
                                    <label class="form-check-label" for="discharge-request" id="dailyLabel">Discharge on Patient Request</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="discharge-refferal" name="discharge"
                                        value="Discharge on Referral" checked>
                                    <label class="form-check-label" for="discharge-referral" id="dailyLabel">Patient Referral</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="discharge-date">Discharge Date</label>
                            <input type="text" class="form-control datepicker-across" name="discharge_date" placeholder="dd/mm/yyyy" id="discharge-date">
                        </div>
                        <div class="col-md-12">
                                <label for="contents">Discharge Summary</label>
                                <textarea name="notes" class="form-control summernote" id="contents" title="Contents"></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="discharge-save"><div class="spinner-grow spinner-grow-sm" id="discharge-save-spinner"></div> Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

