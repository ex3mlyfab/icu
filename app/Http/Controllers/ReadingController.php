<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardioAssessmentRequest;
use App\Http\Requests\FluidBalanceRequest;
use App\Http\Requests\RespiRatoryAssessmentRequest;
use App\Models\CardioAssessment;
use App\Models\FluidBalance;
use App\Models\PatientCare;
use App\Models\RespiratoryAssessment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadingController extends Controller
{
    //
    public $hours = array(
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

    $cardio_chart = [];

    foreach ($this->hours as $key=>$hour) {

         if(isset($cardio_group[$key])){
            foreach($cardio_group[$key] as $value)
            {
                 $cardio_chart['label'][] = $hour;

                $cardio_chart['Heart Rate'][] = (float)$value->heart_rate;
                $cardio_chart['Bp Systolic'][] = (int) $value->blood_pressure_systolic;
                $cardio_chart['Bp Diastolic'][]= (int) $value->blood_pressure_diastolic;
                $cardio_chart['Capillary Refill Time'][] = (int) $value->capillary_refill_time;
                $cardio_chart['CVP'][] = (int) $value->cvp;
                $cardio_chart['MAP'][]= (int) $value->map;
                $cardio_chart['Peripheral pulses'][]= (int) $value->peripheral_pulses;
                $cardio_chart['Rhythm'][] = (int) $value->rhythm;
                $cardio_chart['Respiratory Rate'][] = (int) $value->respiratory_rate;
                $cardio_chart['Temperature'][] = (int) $value->temperature;
                $cardio_chart['Spo2'][] = (int) $value->spo2;

            }
         }else{
         $cardio_chart['label'][] = $hour;

             $cardio_chart['heart rate'][] = '--';
                $cardio_chart['Bp Systolic'][] = '--';
                $cardio_chart['Bp Diastolic'][] = '--';
                $cardio_chart['Capillary Refill Time'][] =  '--';
                $cardio_chart['CVP'][] = '--';
                $cardio_chart['MAP'][]= '--';
                $cardio_chart['peripheral pulses'][] =   '--';
                $cardio_chart['Rhythm'][] = '--';
                $cardio_chart['Respiratory Rate'][] = '--';
                $cardio_chart['Temperature'][] = '--';
                 $cardio_chart['Spo2'][] = '--';

         }


        }
        return response(['data' => $cardio_chart], 200);
    }

    public function storeRespiratory(RespiRatoryAssessmentRequest $request)
    {
         $data = $request->all();

        $data['created_by'] = Auth::user()->id;
        $data['time_of_respiratory_assessment'] = now();
        $record = RespiratoryAssessment::create($data);

        return response(['message'=> 'Respiratory Reading Added successfully'], 200);
    }

    public function showRespiratory(PatientCare $patientCare,$active_day)
    {
        $resp_reading = RespiratoryAssessment::where('patient_care_id', $patientCare->id)
        ->whereDate('created_at', Carbon::parse($active_day))
        ->orderBy('hour_taken')
        ->get();
        $resp_group = $resp_reading->groupBy(function(CardioAssessment $item) {
            return $item->hour_taken->format('H');
        });

        $resp_chart = [];

        foreach($this->hours as $key=>$hour)
        {
            if(isset($resp_group[$key]))
            {
                foreach($resp_group[$key] as $value)
                {
                    $resp_chart['label'][] = $hour;
                    $resp_chart['Mode of Ventilation'][] =$value->mode_of_ventilation;
                    $resp_chart['I E Ration'][] = $value->i_e_ration;
                    $resp_chart['FiO2'][] = $value->fi02;
                    $resp_chart['PEEP'][] = $value->peep;
                    $resp_chart['Tidal Volume'] = $value->patient_tidal_volume;
                    $resp_chart['Ventilator Setting'][] =$value->ventilator_set_rate;
                    $resp_chart['Respiratory Effort'][] = $value->respiratory_effort;
                    $resp_chart['Endothracheal Intubation'][] = $value->endothracheal_intubation;
                    $resp_chart['Pressure Support'][] = $value->pressure_support;

                }
            }else
                {
                    $resp_chart['label'][] = $hour;
                    $resp_chart['Mode of Ventilation'][] = '--';
                    $resp_chart['I E Ration'][] = '--';
                    $resp_chart['FiO2'][] = '--';
                    $resp_chart['PEEP'][] = '--';
                    $resp_chart['Tidal Volume'] = '--';
                    $resp_chart['Ventilator Setting'][] ='--';
                    $resp_chart['Respiratory Effort'][] = '--';
                    $resp_chart['Endothracheal Intubation'][] = '--';
                    $resp_chart['Pressure Support'][] = '--';
                }
            }
            return response(['data' => $resp_chart], 200);
    }

    public function storeFluid(FluidBalanceRequest $request)
    {
        $data = $request->all();

        $data['created_by'] = Auth::user()->id;
        $data['time_of_fluid_assessment'] = now();
        $record = FluidBalance::create($data);

        return response(['message'=> 'Fluid Reading Added successfully'], 200);
    }

    public function showFluid(PatientCare $patientCare,$active_day)
    {
        $fluid_reading = FluidBalance::where('patient_care_id', $patientCare->id)
        ->whereDate('created_at', Carbon::parse($active_day))
        ->orderBy('hour_taken')
        ->get();
        $fluid_group = $fluid_reading->groupBy(function(CardioAssessment $item) {
            return $item->hour_taken->format('H');
        });

        $fluid_chart = [];

        foreach($this->hours as $key=>$hour)
        {
            if(isset($fluid_group[$key]))
            {
                foreach($fluid_group[$key] as $value)
                {
                    $fluid_chart['label'][] = $hour;
                    $fluid_chart['Fluid Type'][] = $value->fluid_type;
                    $fluid_chart['Volume'][] = $value->volume;
                    $fluid_chart['Direction'][] = $value->direction;
                }
            }else
                {
                    $fluid_chart['label'][] = $hour;
                    $fluid_chart['Fluid Type'][] = '--';
                    $fluid_chart['Volume'][] = '--';
                    $fluid_chart['Direction'][] = '--';
                }
            }
            return response(['data' => $fluid_chart], 200);
    }


}
