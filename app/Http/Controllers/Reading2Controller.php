<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabResultRequest;
use App\Models\LabResult;
use App\Models\PatientCare;
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

}
