<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabResultRequest;
use App\Models\InvasiveLine;
use App\Models\LabResult;
use App\Models\PatientCare;
use App\Models\SeizureChart;
use App\Models\SkinWoundCare;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Reading2Controller extends Controller
{
    public function showLab(PatientCare $patientCare, $active_day)
    {
        $labs = LabResult::where('patient_care_id', $patientCare->id)
        ->whereDate('created_at', Carbon::parse($active_day))
        ->get();
        return response($labs, 200);
    }
     public function storeLab(LabResultRequest $request)
    {
        $data = $request->all();


        foreach($data['lab_test'] as $key => $value)
        {
            if(isset($value))
            {
            LabResult::create([
                'patient_care_id' => $data['patient_care_id'],
                'lab_test' => $value,
                'result_received' => 0,
                'created_by' => Auth::user()->id,
                'date_of_result' => now(),
            ]);
        }

        }

        return response(['message'=> 'Lab Result Added successfully'], 200);
    }

    public function updateLab(Request $request)
    {
        $data = $request->all();
        $lab = LabResult::find($data['lab_id']);
        $lab->result_received = 1;
        $lab->save();
        return response(['message'=> 'Lab Result Updated successfully'], 200);
    }

    public function storeSeizure(Request $request)
    {
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $today = now();

        $data['date'] = $today;
        unset($data['hour_taken']);
        $record =SeizureChart::create($data);

        return response(['message'=> 'Seizure Added successfully'], 200);
    }

    public function showSeizure(PatientCare $patientCare)
    {
        $labs = SeizureChart::where('patient_care_id', $patientCare->id)
        ->get();
        $labs = $labs->map(function($item) {
            $item->time = $item->date->format('H:i');
            $item->new_date = $item->date->format('Y-m-d');
            return $item;
        });
        return response($labs, 200);
    }

    public function storeInvasiveLine(Request $request)
    {


        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $data['time_of_invasive_lines'] = now();

        $record =InvasiveLine::create($data);

        return response(['message'=> 'Seizure Added successfully'], 200);
    }

    public function showInvasiveLine(PatientCare $patientCare)
    {
        $labs = InvasiveLine::where('patient_care_id', $patientCare->id)
        ->get();
        $labs = $labs->map(function($item) {
            $item->time = $item->time_of_invasive_lines->format('H:i');
            $item->new_date = $item->time_of_invasive_lines->format('Y-m-d');
            return $item;
        });
        return response($labs, 200);
    }

    public function storeSkinCare(Request $request)
    {
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $data['date_of_care'] = now();

        SkinWoundCare::create($data);

        return response(['message'=> 'Skin Care Added successfully'], 200);
    }

    public function showSkinCare(PatientCare $patientCare)
    {
        $labs = SkinWoundCare::where('patient_care_id', $patientCare->id)
        ->get();

        $labs = $labs->map(function($item) {

            $item->new_date = $item->date_of_care->format('Y-m-d');
            return $item;
        });
        return response($labs, 200);
    }
}
