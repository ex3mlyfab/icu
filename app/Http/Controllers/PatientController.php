<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientRequest;
use App\Models\BedModel;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


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
                'notes' => $data['notes'],
                'bed_model_id' => $data['bed_model_id'],
                'created_by' => Auth::id()
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
        $patients = Patient::with('patientCareLatest')
            ->select('patients.*')
            ->orderBy('created_at', 'desc');

        return DataTables::eloquent($patients)
            ->filter(function ($query) use ($request) {
                if ($request->has('hospital_no')) {
                    $query->where('hospital_no', 'like', "%{$request->get('hospital_no')}%");
                }

            })
            ->editColumn('diagnosis', function ($patient) {
                return $patient->patientCareLatest->diagnosis ?? 'N/A';
            })
            ->editColumn('date_admitted', function ($patient) {
                return $patient->patientCareLatest->admission_date ?? 'N/A';
            })
            ->addColumn('action', function ($patient) {
                return '<div class="btn-group">'.
                '<button type="button" class="btn btn-primary >'.'Actions'.'</button>'.
                '<button type="button" class="btn btn-primary >'.'Process Discharge'.'</button>'.
                '</div>';
            })
            ->setRowId(function ($patient) {
                return "row_".$patient->id;
            })
            ->rawColumns(['diagnosis', 'date_admitted', 'action'])
            ->make(true);
    }

    public function generate_hospital_no()
    {
        $patient_count = Patient::count();
        return str_pad($patient_count + 1, 6, '0', STR_PAD_LEFT);
    }

}
