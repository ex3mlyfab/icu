 <div class="modal fade" id="modal-resp" data-bs-backdrop="static">
     <div class="modal-dialog modal-xl">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">Add New Respiratory Assessment</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
             </div>
             <form id="resp-form">
                 @csrf
                 <input type="hidden" name="patient_care_id" value="{{ $patient->latestPatientCare->id }}">
                 <div class="modal-body">
                     <div class="row">
                         <div class="col-md-12 col-lg-4 mb-3">
                             <div class="input-group flex-nowrap">
                                 <span class="input-group-text" id="addon-wrapping">Mode of Ventilation</span>
                                 <input type="text" class="form-control" name="mode_of_ventilation"
                                     placeholder="Mode of Ventilation">

                             </div>
                         </div>
                         <div class="col-md-12 col-lg-4 mb-3">
                             <div class="input-group flex-nowrap">
                                 <span class="input-group-text" id="addon-wrapping">I.E Ration</span>
                                 <input type="text" class="form-control" name="i_e_ration"
                                     placeholder="Mode of Ventilation">

                             </div>
                         </div>
                         <div class="col-md-12 col-lg-4 mb-3">
                             <div class="input-group flex-nowrap">
                                 <span class="input-group-text" id="addon-wrapping">fi02</span>
                                 <input type="number" class="form-control" name="fi02" placeholder="fi02">

                             </div>
                         </div>
                         <div class="col-md-12 col-lg-4 mb-3">
                             <div class="input-group flex-nowrap">
                                 <span class="input-group-text" id="addon-wrapping">Respiratory Effort</span>
                                 <input type="number" class="form-control" name="respiratory_effort"
                                     placeholder="Respiratory Effort">

                             </div>
                         </div>
                         <div class="col-md-12 col-lg-4 mb-3">
                             <div class="input-group flex-nowrap">
                                 <span class="input-group-text" id="addon-wrapping">PEEP</span>
                                 <input type="number" class="form-control" name="peep" placeholder="peep">

                             </div>
                         </div>
                         <div class="col-md-12 col-lg-4 mb-3">
                             <div class="input-group flex-nowrap">
                                 <span class="input-group-text" id="addon-wrapping">Patient Tidal Volume</span>
                                 <input type="number" class="form-control" name="patient_tidal_volume"
                                     placeholder="Patient Tidal Volume">

                             </div>
                         </div>
                         <div class="col-md-12 col-lg-4 mb-3">
                             <div class="input-group flex-nowrap">
                                 <span class="input-group-text" id="addon-wrapping">Ventilator Set Rate</span>
                                 <input type="number" class="form-control" name="ventilator_set_rate"
                                     placeholder="Ventilator Set Rate">

                             </div>
                         </div>
                         <div class="col-md-12 col-lg-4 mb-3">
                             <div class="input-group flex-nowrap">
                                 <span class="input-group-text" id="addon-wrapping">Endothracheal Intubation</span>
                                 <input type="number" class="form-control" name="endothracheal_intubation"
                                     placeholder="">

                             </div>
                         </div>
                         <div class="col-md-12 col-lg-4 mb-3">
                             <div class="input-group flex-nowrap">
                                 <span class="input-group-text" id="addon-wrapping">Pressure Support</span>
                                 <input type="string" class="form-control" name="pressure_support"
                                     placeholder="pressure_support">

                             </div>
                         </div>
                         <div class="col-md-12 col-lg-4 mb-3">
                             <div class="input-group flex-nowrap">
                                 <span class="input-group-text" id="addon-wrapping">total_expired_volume</span>
                                 <input type="number" class="form-control" name="total_expired_volume"
                                     placeholder="total_expired_volume">

                             </div>
                         </div>

                         <div class="col-md-12 col-lg-4 mb-3">
                             <div class="input-group bootstrap-timepicker timepicker">
                                 <input id="timepicker-respiratoy-respiratory" type="text" name="hour_taken"
                                     class="form-control timepickerAcross">
                                 <span class="input-group-addon input-group-text">
                                     <i class="fa fa-clock"></i>
                                 </span>
                             </div>
                         </div>

                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary" id="resp-save">
                         <div class="spinner-grow spinner-grow-sm" id="resp-save-spinner"></div> Save
                     </button>
                 </div>
             </form>

         </div>
     </div>
 </div>
