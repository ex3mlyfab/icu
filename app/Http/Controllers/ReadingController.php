<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardioAssessmentRequest;
use App\Models\CardioAssessment;
use App\Models\PatientCare;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadingController extends Controller
{
    //
    public function storeCardio(CardioAssessmentRequest $request)
    {
        $data = $request->all();

        $data['created_by'] = Auth::user()->id;
        $data['time_of_cardio_assessment'] = now();

        $record = CardioAssessment::create($data);

        return response(['message'=> 'Cardio Reading Added successfully'], 200);
    }
    public function showCardio(PatientCare $patientCare,$active_day)
    {
        // dump(Carbon::parse($active_day));
    //    $cardio_reading = CardioAssessment::selectRaw('strftime("%H",hour_taken) as Hour, heart_rate, blood_pressure_systolic, blood_pressure_diastolic, temperature, respiratory_rate, weight, map, cvp, rhythm, peripheral_pulses, capillary_refill_time')
    //         ->where('patient_care_id', $patientCare->id)
    //         ->where('created_at', 'like', Carbon::parse($active_day))
    //         ->groupBy('Hour')
    //         ->get();

    $cardio_reading = CardioAssessment::where('patient_care_id', $patientCare->id)
        ->whereDate('created_at', Carbon::parse($active_day))
        ->orderBy('hour_taken')
        ->get();
    $cardio_group = $cardio_reading->groupBy(function(CardioAssessment $item) {
        return $item->hour_taken->format('H');
    });
    $hours = array(
    "06" => "6 AM",
    "07" => "7 AM",
    "08" => "8 AM",
    "09" => "9 AM",
    "10" => "10 AM",
    "11" => "11 AM",
    "12" => "12 PM",
    "13" => "1 PM",
    "14" => "2 PM",
    "15" => "3 PM",
    "16" => "4 PM",
    "17" => "5 PM",
    "18" => "6 PM",
    "19" => "7 PM",
    "20" => "8 PM",
    "21" => "9 PM",
    "22" => "10 PM",
    "23" => "11 PM",
    "00" => "12 AM",
    "01" => "1 AM",
    "02" => "2 AM",
    "03" => "3 AM",
    "04" => "4 AM",
    "05" => "5 AM"
);
    $cardio_chart = [];

    foreach ($hours as $key=>$hour) {

         if(isset($cardio_group[$key])){
            foreach($cardio_group[$key] as $value)
            {
                 $cardio_chart['label'][] = $hour;

                $cardio_chart['heart rate'][] = (float)$value->heart_rate;
                $cardio_chart['Bp Systolic'][] = (int) $value->blood_pressure_systolic;
                $cardio_chart['Bp Diastolic'][]= (int) $value->blood_pressure_diastolic;
                $cardio_chart['Capillary Refill Time'][] = (int) $value->capillary_refill_time;
                $cardio_chart['CVP'][] = (int) $value->cvp;
                $cardio_chart['map'][]= (int) $value->map;
                $cardio_chart['peripheral pulses'][]= (int) $value->peripheral_pulses;
                $cardio_chart['rhythm'][] = (int) $value->rhythm;
                $cardio_chart['respiratory rate'][] = (int) $value->respiratory_rate;
                $cardio_chart['temperature'][] = (int) $value->temperature;
                $cardio_chart['weight'][] = (int) $value->weight;
            }
         }else{
         $cardio_chart['label'][] = $hour;

             $cardio_chart['heart rate'][] = '--';
                $cardio_chart['Bp Systolic'][] = '--';
                $cardio_chart['Bp Diastolic'][] = '--';
                $cardio_chart['Capillary Refill Time'][] =  '--';
                $cardio_chart['CVP'][] = '--';
                $cardio_chart['map'][]= '--';
                $cardio_chart['peripheral pulses'][] =   '--';
                $cardio_chart['rhythm'][] = '--';
                $cardio_chart['respiratory rate'][] = '--';
                $cardio_chart['temperature'][] = '--';
                $cardio_chart['weight'][] =   '--';
         }

    //     if (isset($cardio_group[$key])) {

    //         foreach($cardio_group[$key] as $value)
    //         {
    //             $cardio_chart['heart rate'] = (float) $value->heart_rate;
    //             $cardio_chart['Bp Systolic'] = (int) $value->blood_pressure_systolic;
    //             $cardio_chart['Bp Diastolic'] = (int) $value->blood_pressure_diastolic;
    //             $cardio_chart['Capillary Refill Time'] = (int) $value->capillary_refill_time;
    //             $cardio_chart['CVP'] = (int) $value->cvp;
    //             $cardio_chart['map'] = (int) $value->map;
    //             $cardio_chart['peripheral pulses'] = (int) $value->peripheral_pulses;
    //             $cardio_chart['rhythm'] = (int) $value->rhythm;
    //             $cardio_chart['respiratory rate'] = (int) $value->respiratory_rate;
    //             $cardio_chart['temperature'] = (int) $value->temperature;
    //             $cardio_chart['weight'] = (int) $value->weight;
    //         }
    //     }else{
    //             $cardio_chart['heart rate'] = '--';
    //             $cardio_chart['Bp Systolic'] = '--';
    //             $cardio_chart['Bp Diastolic'] = '--';
    //             $cardio_chart['Capillary Refill Time'] =  '--';
    //             $cardio_chart['CVP'] = '--';
    //             $cardio_chart['map'] = '--';
    //             $cardio_chart['peripheral pulses'] =   '--';
    //             $cardio_chart['rhythm'] = '--';
    //             $cardio_chart['respiratory rate'] = '--';
    //             $cardio_chart['temperature'] = '--';
    //             $cardio_chart['weight'] =   '--';
    //     }
    // }
        }
        return response(['data' => $cardio_chart], 200);
    }
}
