<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class PatientController extends Controller
{
    //
    public function index()
    {
        return view('pages.create_patient_from_emr');
    }

    public function create()
    {
        return view('pages.create_patient');
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
                'hospital_no' => $data['hospital_no'],
                'marital_status' => $data['marital_status'],
                'religion' => $data['religion'],
                'date_of_birth' => $data['date_of_birth'],
                'address' => $data['address'],
                'telephone' => $data['telephone'],

            ]);
            $patient->patientCares()->create($data);

        }
        });


        //if there is a previous record in db

        //save if there is none and start a new careRecord

        //if there is a previous record in db retrieve and start a new careRecord

        //return to dashboard


        dd($data);
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

}
