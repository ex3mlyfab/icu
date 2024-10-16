<?php

use App\Http\Controllers\BedModelController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
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
    //bed model
    Route::get('/beds', [BedModelController::class, 'index'])->name('bed.index');
    Route::post('/get-bed-tabledata', [BedModelController::class, 'get_bed_data'])->name('bed.datatable');
    Route::get('/bed-create', [BedModelController::class,  'create'])->name('bed.create');
    Route::post('/bed-store', [BedModelController::class, 'store'])->name('bed.store');
    Route::get('/bed/{bedModel}/get', [BedModelController::class. 'show'])->name('bed.show');
    Route::patch('/update/{bedModel}/update', [BedModelController::class, 'update'])->name('bed.update');
    Route::delete('/delete/{bedModel}', [BedModelController::class. 'delete'])->name('bed.delete');

    //treatment routes
    Route::get('/show-patient/{patient}/treatment', [PatientController::class, 'show'])->name('patient.treatment');
});

require __DIR__.'/auth.php';


