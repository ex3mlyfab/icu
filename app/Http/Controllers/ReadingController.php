<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardioAssessmentRequest;
use App\Http\Requests\FluidBalanceRequest;
use App\Http\Requests\MedicationRequest;
use App\Http\Requests\NeuroAssessmentRequest;
use App\Http\Requests\NutritionRequest;
use App\Http\Requests\RespiRatoryAssessmentRequest;
use App\Models\CardioAssessment;
use App\Models\FluidBalance;
use App\Models\Medication;
use App\Models\NeuroAssessment;
use App\Models\Nutrition;
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

             $cardio_chart['Heart Rate'][] = '--';
                $cardio_chart['Bp Systolic'][] = '--';
                $cardio_chart['Bp Diastolic'][] = '--';
                $cardio_chart['Capillary Refill Time'][] =  '--';
                $cardio_chart['CVP'][] = '--';
                $cardio_chart['MAP'][]= '--';
                $cardio_chart['Peripheral pulses'][] =   '--';
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
        $resp_group = $resp_reading->groupBy(function(RespiratoryAssessment $item) {
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
                    $resp_chart['Mode of Ventilation'][] =$value->mode_of_ventilation ?? '--';
                    $resp_chart['I E Ration'][] = $value->i_e_ration ?? '--';
                    $resp_chart['FiO2'][] = $value->fi02 ?? '--';
                    $resp_chart['PEEP'][] = $value->peep ?? '--';
                    $resp_chart['Tidal Volume'] = $value->patient_tidal_volume ?? '--';
                    $resp_chart['Ventilator Setting'][] =$value->ventilator_set_rate ?? '--';
                    $resp_chart['Respiratory Effort'][] = $value->respiratory_effort ?? '--';
                    $resp_chart['Endothracheal Intubation'][] = $value->endothracheal_intubation ?? '--';
                    $resp_chart['Pressure Support'][] = $value->pressure_support ?? '--';

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
        //  dd($data);

       if($data['fluid_select'] == 'others')
       {
           $fluidRecord = FluidBalance::create([
            'patient_care_id' => $data['patient_care_id'],
            'fluid' => $data['fluid_name'],
            'volume' => $data['volume'],
            'direction' => $data['direction'],
            'hour_taken' => $data['hour_taken'],
            'created_by' => Auth::user()->id,
            'time_of_fluid_balance' => now(),
           ]);
       }else{
            $fluidBefore = FluidBalance::where('patient_care_id', $data['patient_care_id'])
                            ->where('fluid', $data['fluid_select'])->first();
            // dump($fluidBefore);
            $newrecord = FluidBalance::create([
            'patient_care_id' => $data['patient_care_id'],
            'fluid' => $fluidBefore->fluid,
            'volume' => $data['volume'],
            'direction' => $fluidBefore->direction,
            'hour_taken' => $data['hour_taken'],
            'created_by' => Auth::user()->id,
            'time_of_fluid_balance' => now(),
           ]);
       }


        return response(['message'=> 'Fluid Reading Added successfully'], 200);
    }

    public function showFluid(PatientCare $patientCare,$active_day)
    {
        $fluid_reading = FluidBalance::where('patient_care_id', $patientCare->id)
        ->whereDate('created_at', Carbon::parse($active_day))
        ->orderBy('hour_taken')
        ->get();
        $fluid_group = $fluid_reading->groupBy(function(FluidBalance $item) {
            return $item->hour_taken->format('H');
        });
        $fluid_names = $fluid_reading->unique('fluid')->select(['fluid', 'direction']);
        // dump($fluid_names);
        $fluid_chart = [];

        foreach($this->hours as $key=>$hour)
        {
            if(isset($fluid_group[$key]))
            {
                foreach($fluid_group[$key] as $value)
                {
                    $fluid_chart['label'][] = $hour;
                    $fluid_chart[$value->fluid][] = $value->volume;
                    $fluid_chart['Direction'][] = $value->direction;
                }
            }else
                {
                    $fluid_chart['label'][] = $hour;
                    foreach($fluid_names as $name)
                    {
                        $fluid_chart[$name['fluid']][] = "--";
                        $fluid_chart['Direction'][] =$name['direction'];
                    }

                }
            }
            return response(['data' => $fluid_chart], 200);
    }

    public function getFluid(PatientCare $patientCare)
    {

        return response(['data' => $patientCare->fluidBalances->unique('fluid')], 200);
    }
    public function getMedication(PatientCare $patientCare)
    {
        return response($patientCare->medications->unique('medication'), 200);
    }
    public function showMedication(PatientCare $patientCare, $active_day)
    {
        // $medication_reading =
        $medication_reading = Medication::where('patient_care_id', $patientCare->id)
                        ->whereDate('created_at', Carbon::parse($active_day))
                        ->orderBy('hour_taken')
                        ->get();
        $medication_group = $medication_reading->groupBy(function(Medication $item) {
            return $item->hour_taken->format('H');
        });
        $medication_names = $medication_reading->unique('medication')->select(['medication', 'dosage', 'frequency']);
        // dump($fluid_names);
        $medication_chart = [];

        foreach($this->hours as $key=>$hour)
        {
            if(isset($medication_group[$key]))
            {
                foreach($medication_group[$key] as $value)
                {
                    $medication_chart['label'][] = $hour;
                    $medication_chart[$value->medication][] = $value->dosage;

                }
            }else
                {
                    $medication_chart['label'][] = $hour;
                    foreach($medication_names as $name)
                    {
                        $medication_chart[$name['medication']][] = "--";

                    }

                }
            }
            return response(['data' => $medication_chart], 200);

    }
    public function storeMedication(MedicationRequest $request)
    {
        $data= $request->all();
         if($data['medication_select'] == 'others')
         {
             $medicationRecord = Medication::create([
                'patient_care_id' => $data['patient_care_id'],
                'medication' => $data['medication_name'],
                'dosage' => $data['dosage'],
                'frequency' => $data['frequency'],
                'created_by' => Auth::user()->id,
                'hour_taken' => $data['hour_taken'],
                'time_of_medication' => now(),
             ]);
         }else{
            $medicationBefore = Medication::where('patient_care_id', $data['patient_care_id'])
                            ->where('medication', $data['medication_select'])->first();
            // dump($fluidBefore);
            $newrecord = Medication::create([
            'patient_care_id' => $data['patient_care_id'],
            'medication' => $medicationBefore->medication,
            'dosage' => $data['dosage'],
            'frequency' => $medicationBefore->frequency,
            'created_by' => Auth::user()->id,
            'hour_taken' => $data['hour_taken'],
            'time_of_medication' => now(),
        ]);
         }

         return response(['message'=> 'Medication Added successfully'], 200);
    }
    public function getNutrition(PatientCare $patientCare)
    {
        return response($patientCare->nutritions->unique('feeding_route'), 200);
    }
    public function showNutrition(PatientCare $patientCare, $active_day)
    {
        // $medication_reading =
        $nutrition_reading = Nutrition::where('patient_care_id', $patientCare->id)
                        ->whereDate('created_at', Carbon::parse($active_day))
                        ->orderBy('hour_taken')
                        ->get();
        $nutrition_group = $nutrition_reading->groupBy(function(Nutrition $item) {
            return $item->hour_taken->format('H');
        });
        $nutrition_names = $nutrition_reading->unique('Nutrition')->select(['feeding_route', 'caloric_intake']);
        // dump($fluid_names);
        $nutrition_chart = [];

        foreach($this->hours as $key=>$hour)
        {
            if(isset($nutrition_group[$key]))
            {
                foreach($nutrition_group[$key] as $value)
                {
                    $nutrition_chart['label'][] = $hour;
                    $nutrition_chart[$value->feeding_route][] = $value->caloric_intake;

                }
            }else
                {
                    $nutrition_chart['label'][] = $hour;
                    foreach($nutrition_names as $name)
                    {
                        $nutrition_chart[$name['feeding_route']][] = "--";

                    }

                }
            }
            return response(['data' => $nutrition_chart], 200);

    }
    public function storeNutrition(NutritionRequest $request)
    {
        $data= $request->all();
         if($data['nutrition_select'] == 'others')
         {
             $medicationRecord = Nutrition::create([
                'patient_care_id' => $data['patient_care_id'],
                'feeding_route' => $data['nutrition_name'],
                'caloric_intake' => $data['caloric_intake'],

                'created_by' => Auth::user()->id,
                'hour_taken' => $data['hour_taken'],
                'time_of_nutrition' => now(),
             ]);
         }else{
            $medicationBefore = Nutrition::where('patient_care_id', $data['patient_care_id'])
                            ->where('medication', $data['nutrition_select'])->first();
            // dump($fluidBefore);
            $newrecord = Nutrition::create([
            'patient_care_id' => $data['patient_care_id'],
            'feeding_route' => $medicationBefore->feeding_route,
            'caloric_intake' => $data['caloric_intake'],
            'created_by' => Auth::user()->id,
            'hour_taken' => $data['hour_taken'],
            'time_of_nutrition' => now(),
        ]);
         }

         return response(['message'=> 'Nutrition Added successfully'], 200);
    }
    public function storeNeuro(NeuroAssessmentRequest $request)
    {
        $data= $request->all();
         $medicationRecord = NeuroAssessment::create([
            'patient_care_id' => $data['patient_care_id'],
            'eyes_open' => $data['eyes_open'],
            'sedated' => $data['sedated'],
            'best_verbal_response' => $data['best_verbal_response'],
            'intubated' => $data['intubated'],
            'best_motor_response' => $data['best_motor_response'],
            'sedation_score' => $data['sedation_score'],
            'pupil_diameter' => $data['pupil_diameter'],
            'hour_taken' => $data['hour_taken'],
            'time_of_neuro_assessment' => now(),
         ]);
         return response(['message'=> 'Neuro Added successfully'], 200);
    }
    public function showNeuro(PatientCare $patientCare, $active_day)
    {
        $neuro_reading = NeuroAssessment::where('patient_care_id', $patientCare->id)
                        ->whereDate('created_at', Carbon::parse($active_day))
                        ->get();
        $neuro_chart = [];
        foreach($neuro_reading as $reading)
        {
            $neuro_chart['eyes_open'][] = $reading->eyes_open;
            $neuro_chart['sedated'][] = $reading->sedated;
            $neuro_chart['intubated'][] = $reading->intubated;
            $neuro_chart['best_verbal_response'][] = $reading->best_verbal_response;
            $neuro_chart['sedation_score'][] = $reading->sedation_score;
            $neuro_chart['pupil_diameter'][] = $reading->pupil_diameter;
            $neuro_chart['hour_taken'][] = $reading->hour_taken->format('H');
        }
        return response($neuro_chart, 200);
    }

}
