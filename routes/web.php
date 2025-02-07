<?php

use App\Http\Controllers\BedModelController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Reading2Controller;
use App\Http\Controllers\ReadingController;
use App\Http\Controllers\UserController;

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
     Route::get('/home', function(){
        redirect('/dashboard');
    });
    Route::get('/testing', function () {
    return view('pages.testing');
});
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //change password
    Route::get('/change-password', [UserController::class, 'changePassword'])->name('password-change');
    Route::post('/update-password', [UserController::class, 'updatePassword'])->name('change-password');
    //patient- related routes
    Route::get('/create-patient-from-emr', [PatientController::class, 'index'])->name('create-patient-from-emr')->can('add-patient');
    Route::get('/create-patient', [PatientController::class, 'create'])->name('create-patient')->can('add-patient');
    Route::post('/store-patient', [PatientController::class, 'store'])->name('patient.store')->can('add-patient');
    Route::post('/get-table-data', [PatientController::class, 'get_table_data'])->name('patient.data')->can('view-patient');
    Route::post('/get-patient-data', [PatientController::class, 'get_patient_table'])->name('patient_all.data')->can('view-patient');
    Route::get('/show-patient/{patient}', [PatientController::class, 'showPatient'])->name('patient.show')->can('view-patient');
    Route::get('/patients-list', [PatientController::class, 'patientList'])->name('patient.list')->can('view-patient');

    //bed model
    Route::get('/beds', [BedModelController::class, 'index'])->name('bed.index')->can('view-bed');
    Route::post('/get-bed-tabledata', [BedModelController::class, 'get_bed_data'])->name('bed.datatable')->can('view-bed');
    Route::get('/bed-create', [BedModelController::class,  'create'])->name('bed.create')->can('add-bed');
    Route::post('/bed-store', [BedModelController::class, 'store'])->name('bed.store')->can('add-bed');
    Route::get('/bed/{bedModel}/get', [BedModelController::class, 'show'])->name('bed.show')->can('view-bed');
    Route::patch('/update/{bedModel}/update', [BedModelController::class, 'update'])->name('bed.update')->can('update-bed');
    Route::delete('/delete/{bedModel}', [BedModelController::class. 'delete'])->name('bed.delete')->can('delete-bed');

    //treatment routes
    Route::get('/show-patient/{patient}/treatment', [PatientController::class, 'show'])->name('patient.treatment')->can('view-encounter');
    //discharged View
    Route::get('/show-patient/discharged/{patientCare}', [PatientController::class, 'dischargedView'])->name('patient_view.discharged')->can('discharge-patient');

    //cardio assessment routes
    Route::get('/show-patient/{patientCare}/cardio-assessment/{active_day}', [ReadingController::class, 'showCardio'])->name('cardio.show');
    Route::get('/show-cardio/{patientCare}/{active_day}/{viewtype}', [ReadingController::class, 'newCardioShow'])->name('cardio.newShow');
    Route::post('/store-cardio-assessment', [ReadingController::class, 'storeCardio'])->name('cardio.store')->can('add-cardio');
    //respiratory Assessment Route
    Route::get('/show-patient/{patientCare}/resp-assessment/{active_day}', [ReadingController::class, 'showRespiratory'])->name('resp.show');
    Route::get('/show/{patientCare}/{active_day}/{viewtype}', [ReadingController::class, 'newShowRespiratory'])->name('resp.newShow');
    Route::post('/store-respiratory-assessment', [ReadingController::class,'storeRespiratory'])->name('resp.store')->can('add-respiratory');
    //fluid balance routes
    Route::get('/get-patient-fluids/{patientCare}/select', [ReadingController::class, 'getFluid'])->name('fluid.get');
    Route::get('/show-patient/{patientCare}/fluid-assessment/{active_day}/{viewtype}', [ReadingController::class, 'showFluid'])->name('fluid.show');
    Route::post('/store-fluid-assessment', [ReadingController::class, 'storeFluid'])->name('fluid.store')->can('add-fluid-balance');
    Route::get('/fluid-chart/{patientCare}/{active_day}', [Reading2Controller::class, 'fluidChart'])->name('fluid.chart');
    
    //medication routes
    Route::get('/show-patient/{patientCare}/medication/{active_day}/{viewtype}', [ReadingController::class, 'showMedication'])->name('medication.show');
    Route::post('/store-medication', [ReadingController::class, 'storeMedication'])->name('medication.store')->can('add-medication');
    Route::get('/get-patient-medications/{patientCare}/select', [ReadingController::class, 'getMedication'])->name('medication.get');

    //neuro Assessment routes
    Route::get('/show-patient/{patientCare}/neuro-assessment/{active_day}/{viewtype}', [ReadingController::class, 'showNeuro'])->name('neuro.show');
    Route::post('/store-neuro-assessment', [ReadingController::class, 'storeNeuro'])->name('neuro.store')->can('add-neuro');

    //nutritions routes
    Route::get('/show-patient/{patientCare}/nutritions/{active_day}/{viewtype}', [ReadingController::class, 'showNutrition'])->name('nutrition.show');
    Route::post('/store-nutritions', [ReadingController::class, 'storeNutrition'])->name('nutrition.store')->can('add-nutrition');
    Route::get('/get-patient-nutritions/{patientCare}/select', [ReadingController::class, 'getNutrition'])->name('nutrition.get');

    //seizure Chart routes
    Route::get('/show-patient/{patientCare}/seizure-chart', [Reading2Controller::class, 'showSeizure'])->name('seizure.show');
    Route::post('/store-seizure-chart', [Reading2Controller::class, 'storeSeizure'])->name('seizure.store')->can('add-seizure');

    // Lab test routes
    Route::get('/show-patient/{patientCare}/lab-test/{active_day}', [Reading2Controller::class, 'showLab'])->name('lab.show');
    Route::post('/store-lab-test', [Reading2Controller::class, 'storeLab'])->name('lab.store')->can('add-lab-test');
    Route::post('/update-lab-test', [Reading2Controller::class, 'updateLab'])->name('collect-result.store');
    //invasive line routes
    Route::get('/show-patient/{patientCare}/invasive-line', [Reading2Controller::class, 'showInvasiveLine'])->name('invasive.show');
    Route::post('/store-invasive-line', [Reading2Controller::class, 'storeInvasiveLine'])->name('invasive.store')->can('add-invasive-line');
    //dailynotes
    Route::get('/show-patient/{patientCare}/dailynotes/{active_day}/{viewtype}', [Reading2Controller::class, 'showDailyNote'])->name('dailynotes.show');
    Route::post('/store-dailynotes', [Reading2Controller::class, 'storeDailyNote'])->name('dailynotes.store')->can('add-daily-notes');
    //physician order
    Route::get('/show-patient/{patientCare}/physician-order/{active_day}/{viewtype}', [Reading2Controller::class, 'showPhysicianNote'])->name('physician.show');
    Route::post('/store-physician-order', [Reading2Controller::class, 'storePhysicianNote'])->name('physician.store')->can('add-physician-notes');
    //skin care Route
    Route::get('/show-patient/{patientCare}/skin-care/{active_day}/{viewtype}', [Reading2Controller::class, 'showSkinCare'])->name('skin.show');
    Route::post('/store-skin-care', [Reading2Controller::class, 'storeSkinCare'])->name('skin.store')->can('add-skin-care');
    //renal fluids
    Route::get('/show-patient/{patientCare}/renal-fluids/{active_day}', [Reading2Controller::class, 'renalFluid'])->name('renal.show');
    //store Daily Treatment
    Route::post('/store-daily-treatment', [Reading2Controller::class, 'storeDailyTreatment'])->name('dailyTreatment.store')->can('add-daily-treatment');
    Route::get('/show-patient/{patientCare}/daily-treatment/{active_day}', [Reading2Controller::class, 'showDailyTreatment'])->name('dailyTreatment.show');
    //discharge Patient
    Route::post('/discharge-patient', [Reading2Controller::class, 'dischargePatient'])->name('patient.discharge')->can('discharge-patient');
    //permission & Roles
    Route::get('admin/permissions', [PermissionController::class, 'index'])->name('permission.index')->can('view-permission');
    Route::post('admin/permissionn', [PermissionController::class, 'storePermissions'])->name('permission.store')->can('add-permission');
    Route::get('admin/permissionn/get', [PermissionController::class, 'getPermissions'])->name('permission.get')->can('view-permission');
    Route::get('admin/roles', [PermissionController::class, 'getRoles'])->name('role.get')->can('view-role');
    Route::get('admin/assign-role', [PermissionController::class, 'assignRole'])->name('role.assign')->can('assign-role');
    Route::post('admin/roles', [PermissionController::class, 'createRole'])->name('role.create')->can('add-role');
    Route::post('admin/role/update', [PermissionController::class, 'updateRole'])->name('role.update')->can('update-role');
    Route::get('admin/page/create-role', [PermissionController::class, 'createRolePage'])->name('role.createPage')->can('add-role');
    Route::get('get-all-permission', [PermissionController::class, 'getallPermission'])->name('permission.all')->can('view-permission');
    //User creation and listing

    Route::get('admin/users-create', [UserController::class, 'createUserPage'])->name('user.create')->can('create-user');
    Route::get('admin/users-list', [UserController::class, 'userIndex'])->name('user.index')->can('view-user');
    Route::post('admin/users-list', [UserController::class, 'get_user_table'])->name('datatable.user')->can('view.user');
    Route::post('admin/users-store', [UserController::class, 'createUser'])->name('user.store')->can('create-user');
});

require __DIR__.'/auth.php';


