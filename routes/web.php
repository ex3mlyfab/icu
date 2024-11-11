<?php

use App\Http\Controllers\BedModelController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Reading2Controller;
use App\Http\Controllers\ReadingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [PatientController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //patient- related routes
    Route::get('/create-patient-from-emr', [PatientController::class, 'index'])->name('create-patient-from-emr');
    Route::get('/create-patient', [PatientController::class, 'create'])->name('create-patient');
    Route::post('/store-patient', [PatientController::class, 'store'])->name('patient.store');
    Route::post('/get-table-data', [PatientController::class, 'get_table_data'])->name('patient.data');
    Route::post('/get-patient-data', [PatientController::class, 'get_patient_table'])->name('patient_all.data');
    Route::get('/show-patient/{patient}', [PatientController::class, 'showPatient'])->name('patient.show');
    Route::get('/patients-list', [PatientController::class, 'patientList'])->name('patient.list');

    //bed model
    Route::get('/beds', [BedModelController::class, 'index'])->name('bed.index');
    Route::post('/get-bed-tabledata', [BedModelController::class, 'get_bed_data'])->name('bed.datatable');
    Route::get('/bed-create', [BedModelController::class,  'create'])->name('bed.create');
    Route::post('/bed-store', [BedModelController::class, 'store'])->name('bed.store');
    Route::get('/bed/{bedModel}/get', [BedModelController::class, 'show'])->name('bed.show');
    Route::patch('/update/{bedModel}/update', [BedModelController::class, 'update'])->name('bed.update');
    Route::delete('/delete/{bedModel}', [BedModelController::class. 'delete'])->name('bed.delete');

    //treatment routes
    Route::get('/show-patient/{patient}/treatment', [PatientController::class, 'show'])->name('patient.treatment');
    //discharged View
    Route::get('/show-patient/discharged/{patientCare}', [PatientController::class, 'dischargedView'])->name('patient_view.discharged');

    //cardio assessment routes
    Route::get('/show-patient/{patientCare}/cardio-assessment/{active_day}', [ReadingController::class, 'showCardio'])->name('cardio.show');
    Route::post('/store-cardio-assessment', [ReadingController::class, 'storeCardio'])->name('cardio.store');
    //respiratory Assessment Route
    Route::get('/show-patient/{patientCare}/resp-assessment/{active_day}', [ReadingController::class, 'showRespiratory'])->name('resp.show');
    Route::post('/store-respiratory-assessment', [ReadingController::class,'storeRespiratory'])->name('resp.store');
    //fluid balance routes
    Route::get('/get-patient-fluids/{patientCare}/select', [ReadingController::class, 'getFluid'])->name('fluid.get');
    Route::get('/show-patient/{patientCare}/fluid-assessment/{active_day}', [ReadingController::class, 'showFluid'])->name('fluid.show');
    Route::post('/store-fluid-assessment', [ReadingController::class, 'storeFluid'])->name('fluid.store');
    //medication routes
    Route::get('/show-patient/{patientCare}/medication/{active_day}', [ReadingController::class, 'showMedication'])->name('medication.show');
    Route::post('/store-medication', [ReadingController::class, 'storeMedication'])->name('medication.store');
    Route::get('/get-patient-medications/{patientCare}/select', [ReadingController::class, 'getMedication'])->name('medication.get');

    //neuro Assessment routes
    Route::get('/show-patient/{patientCare}/neuro-assessment/{active_day}', [ReadingController::class, 'showNeuro'])->name('neuro.show');
    Route::post('/store-neuro-assessment', [ReadingController::class, 'storeNeuro'])->name('neuro.store');

    //nutritions routes
    Route::get('/show-patient/{patientCare}/nutritions/{active_day}', [ReadingController::class, 'showNutrition'])->name('nutrition.show');
    Route::post('/store-nutritions', [ReadingController::class, 'storeNutrition'])->name('nutrition.store');
    Route::get('/get-patient-nutritions/{patientCare}/select', [ReadingController::class, 'getNutrition'])->name('nutrition.get');

    //seizure Chart routes
    Route::get('/show-patient/{patientCare}/seizure-chart', [Reading2Controller::class, 'showSeizure'])->name('seizure.show');
    Route::post('/store-seizure-chart', [Reading2Controller::class, 'storeSeizure'])->name('seizure.store');

    // Lab test routes
    Route::get('/show-patient/{patientCare}/lab-test/{active_day}', [Reading2Controller::class, 'showLab'])->name('lab.show');
    Route::post('/store-lab-test', [Reading2Controller::class, 'storeLab'])->name('lab.store');
    Route::post('/update-lab-test', [Reading2Controller::class, 'updateLab'])->name('collect-result.store');
    //invasive line routes
    Route::get('/show-patient/{patientCare}/invasive-line', [Reading2Controller::class, 'showInvasiveLine'])->name('invasive.show');
    Route::post('/store-invasive-line', [Reading2Controller::class, 'storeInvasiveLine'])->name('invasive.store');
    //dailynotes
    Route::get('/show-patient/{patientCare}/dailynotes/{active_day}', [Reading2Controller::class, 'showDailyNote'])->name('dailynotes.show');
    Route::post('/store-dailynotes', [Reading2Controller::class, 'storeDailyNote'])->name('dailynotes.store');
    //physician order
    Route::get('/show-patient/{patientCare}/physician-order/{active_day}', [Reading2Controller::class, 'showPhysicianNote'])->name('physician.show');
    Route::post('/store-physician-order', [Reading2Controller::class, 'storePhysicianNote'])->name('physician.store');
    //skin care Route
    Route::get('/show-patient/{patientCare}/skin-care/{active_day}', [Reading2Controller::class, 'showSkinCare'])->name('skin.show');
    Route::post('/store-skin-care', [Reading2Controller::class, 'storeSkinCare'])->name('skin.store');
    //renal fluids
    Route::get('/show-patient/{patientCare}/renal-fluids/{active_day}', [Reading2Controller::class, 'renalFluid'])->name('renal.show');
    //store Daily Treatment
    Route::post('/store-daily-treatment', [Reading2Controller::class, 'storeDailyTreatment'])->name('dailyTreatment.store');
    Route::get('/show-patient/{patientCare}/daily-treatment/{active_day}', [Reading2Controller::class, 'showDailyTreatment'])->name('dailyTreatment.show');
    //discharge Patient
    Route::post('/discharge-patient', [Reading2Controller::class, 'dischargePatient'])->name('patient.discharge');


});

require __DIR__.'/auth.php';


