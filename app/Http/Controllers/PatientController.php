<?php

namespace App\Http\Controllers;

use App\Enums\GenderEnum;
use App\Http\Requests\CreatePatientRequest;
use App\Models\BedModel;
use App\Models\Patient;
use App\Models\PatientCare;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

use function Symfony\Component\Clock\now;

class PatientController extends Controller
{
    //
    public function index()
    {
         $available_bed = BedModel::where('is_deleted', 0)
                            ->where('is_active', 0)->get(['id', 'name', 'section']);
        return view('pages.create_patient_from_emr',
    [
         'available_bed' => $available_bed
    ]);
    }

    public function patientList()
    {
        return view('pages.patients');
    }
    public function showPatient(Patient $patient)
    {
        return view('pages.details', [
            'patient' => $patient
        ]);
    }

    public function dashboard(){
        $bed_count= BedModel::where('is_deleted',0)->count();
        $occupied = BedModel::where('is_active', 1)->count();
        return view('pages.index',[
            'bed_count' => $bed_count,
            'occupied' => $occupied
        ]);
    }
    public function create()
    {
        $available_bed = BedModel::where('is_deleted', 0)
                            ->where('is_active', 0)->get(['id', 'name', 'section']);
        return view('pages.create_patient', [
            'available_bed' => $available_bed
        ]);
    }

    public function store(CreatePatientRequest $request)
    {
        $data = $request->all();


        DB::transaction(function () use ($data) {
        if(!isset($data['hospital_no'])){
            $data['hospital_no'] = $this->generate_hospital_no();
        }
            //check if patient has previous record in db
        $patient = Patient::where('hospital_no', $data['hospital_no'])->first();
        if (!$patient) {
            //save if there is none and start a new careRecord
            $patient = Patient::create([
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'],
                'last_name' => $data['last_name'],
                'gender' => $data['gender'],
                'hospital_no' => $this->generate_hospital_no(),
                'marital_status' => $data['marital_status'],
                'religion' => $data['religion'],
                'date_of_birth' => $data['date_of_birth'],
                'address' => $data['address'],
                'telephone' => $data['telephone'],
                'occupation' => $data['occupation'],
                'state_of_origin' => $data['state_of_origin'],
                'religion' => $data['religion'],
                'next_of_kin' => $data['next_of_kin'],
                'next_of_kin_address' => $data['next_of_kin_address'],
                'next_of_kin_telephone' => $data['next_of_kin_telephone'],
                'next_of_kin_relationship' => $data['next_of_kin_relationship'],

            ]);
            }

            $patient->patientCares()->create([
                'admission_date' => $data['admission_date'],
                'diagnosis' => $data['diagnosis'],
                'icu_consultant' => $data['icu_consultant'],
                'admitted_from' => $data['admitted_from'],
                'nurse_incharge' => $data['nurse_incharge'],
                'notes' => $data['condition'],
                'bed_model_id' => $data['bed_model_id'],
                'created_by' => Auth::id()
            ]);
           $bedModel = BedModel::find($data['bed_model_id']);
           $bedModel->update(['is_active' => 1]);
           $bedModel->bedOccupationHistory()->create([
               'start_date' => $data['admission_date'],
               'patient_care_id' => $patient->latestPatientCare->id,
               'is_occupied' => 1,
           ]);

        });


        //if there is a previous record in db

        //save if there is none and start a new careRecord

        //if there is a previous record in db retrieve and start a new careRecord

        //return to dashboard
        return redirect()->route('dashboard');

    }

    public function get_table_data( Request $request )
    {
        $patients = PatientCare::with('patient')
                    ->where('ready_for_discharge', 0)
                    ->leftJoin('patients', 'patient_cares.patient_id', '=', 'patients.id')
                    ->select('patient_cares.*', 'patients.*')
                    ->orderBy('created_at', 'desc');

        return DataTables::eloquent($patients)
            ->filter(function ($query) use ($request) {
                if ($request->has('hospital_no')) {
                    $query->whereHas('patient', function($query) use ($request) {
                        $query->where('hospital_no', 'like', "%{$request->get('hospital_no')}%");
                    });
                }

            })
            ->editColumn('gendervalue', function ($patient) {

                return $patient->patient->gender->name;
            })
            ->editColumn('fullname', function ($patient) {
                return $patient->patient->fullname;
            })
            ->editColumn('diagnosis', function ($patient) {
                return $patient->diagnosis ?? 'N/A';
            })
            ->editColumn('date_admitted', function ($patient) {
                return $patient->admission_date->format('d/m/Y') ?? 'N/A';
            })
            ->addColumn('action', function ($patient) {
                return '<div class="btn-group">'.
                '<a href="'.route('patient.treatment', $patient->patient->id).'" class="btn btn-outline-primary">'.'Record'.'</a>'.
                '<a type="button" class="btn btn-outline-primary process-discharge" data-bs-toggle="modal" data-bs-target="#modal-discharge" data-patient-id="'.$patient->id.'"> '.'Process Discharge'.'</a>'.
                '</div>';
            })
            ->setRowId(function ($patient) {
                return "row_".$patient->id;
            })
            ->rawColumns(['gendervalue','diagnosis', 'date_admitted', 'action'])
            ->make(true);
    }

    public function get_patient_table(Request $request)
    {
        $patients = Patient::with('patientCares')
            ->select('patients.*')
            ->orderBy('created_at', 'desc');

        return DataTables::eloquent($patients)
            ->filter(function ($query) use ($request) {
                if ($request->has('hospital_no')) {
                    $query->where('hospital_no', 'like', "%{$request->get('hospital_no')}%");
                }

            })
            ->editColumn('gendervalue', function ($patient) {

                return $patient->gender->name;
            })
            ->editColumn('fullname', function ($patient) {
                return $patient->fullname;
            })
            ->editColumn('encounter_count', function ($patient) {
              return $patient->patientCares->count();
            })
            ->editColumn('current_status', function ($patient) {
                return $patient->latestPatientCare->admission_date->format('d/m/Y') ?? 'N/A';
            })
            ->addColumn('action', function ($patient) {
                return '<div class="btn-group">'.
                '<a href="'.route('patient.show', $patient->id).'" class="btn btn-outline-primary">'.'SHow Patient Info'.'</a>'.

                '</div>';
            })
            ->setRowId(function ($patient) {
                return "row_".$patient->id;
            })
            ->rawColumns(['gendervalue','encounter_count', 'current_status', 'action'])
            ->make(true);
    }
    public function generate_hospital_no()
    {
        $patient_count = Patient::count();
        return str_pad($patient_count + 1, 6, '0', STR_PAD_LEFT);
    }

    public function show(Patient $patient)
    {
        $dates = $this->generate_dates_between($patient->latestPatientCare->admission_date, Carbon::parse(now()));
        return view('pages.show_patient', compact('patient', 'dates'));
    }
    public function dischargedView(PatientCare $patientCare)
    {
        $dates = $this->generate_dates_between($patientCare->admission_date, $patientCare->discharge_date);
        return view('pages.discharged', compact('patientCare', 'dates'));
    }
    function generate_dates_between(Carbon $start_date, Carbon $end_date): array
     {
    $dates = [];

    $current_date = $start_date;

    while ($current_date <= $end_date) {
        $dates[] = $current_date->copy();
        $current_date->addDay();
    }

    return $dates;
}
}
