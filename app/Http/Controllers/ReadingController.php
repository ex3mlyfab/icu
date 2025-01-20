<?php

namespace App\Http\Controllers;
use Illuminate\Support\Arr;
use App\Enums\EyesOpenEnum;
use App\Enums\MotorResponseEnum;
use App\Enums\SedationScoreEnum;
use App\Enums\VerbalResponseEnum;
use App\Http\Requests\CardioAssessmentRequest;
use App\Http\Requests\FluidBalanceRequest;
use App\Http\Requests\LabResultRequest;
use App\Http\Requests\MedicationRequest;
use App\Http\Requests\NeuroAssessmentRequest;
use App\Http\Requests\NutritionRequest;
use App\Http\Requests\RespiRatoryAssessmentRequest;
use App\Models\CardioAssessment;
use App\Models\FluidBalance;
use App\Models\LabResult;
use App\Models\Medication;
use App\Models\NeuroAssessment;
use App\Models\Nutrition;
use App\Models\PatientCare;
use App\Models\RespiratoryAssessment;
use App\Models\User;
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
    public function newCardioShow(PatientCare $patientCare, $active_day)
    {
        $cardio_reading = CardioAssessment::where('patient_care_id', $patientCare->id)
        ->whereDate('created_at', Carbon::parse($active_day))
        ->orderBy('created_at')
        ->get();

        $cardio_reading = $cardio_reading->groupBy(function (CardioAssessment $item) {
            return $item->created_at->format('d/m/Y h:i:s A');
        });
        $cardioChart = [];

        //select the last two grouping in $cardio_reading
        $lastTwoGroups = $cardio_reading->slice(-2);

        foreach ($lastTwoGroups as $time => $readings) {
            foreach ($readings as $reading) {
                $cardioChart['label'][] = $time;
                $cardioChart['heart_rate'][] = (float)$reading->heart_rate;
                $cardioChart['BpSystolic'][] = (int)$reading->blood_pressure_systolic;
                $cardioChart['BpDiastolic'][] = (int)$reading->blood_pressure_diastolic;
                $cardioChart['CapillaryRefillTime'][] = (int)$reading->capillary_refill_time;
                $cardioChart['CVP'][] = (int)$reading->cvp;
                $cardioChart['MAP'][] = (int)$reading->map;
                $cardioChart['Peripheralpulses'][] = (int)$reading->peripheral_pulses;
                $cardioChart['Rhythm'][] = (int)$reading->rhythm;
                $cardioChart['RespiratoryRate'][] = (int)$reading->respiratory_rate;
                $cardioChart['Temperature'][] = (int)$reading->temperature;
                $cardioChart['Spo2'][] = (int)$reading->spo2;
                $cardioChart['Recordedby'][] = $reading->createdBy->fullname;
            }
        }

        return response([
            'data' => $cardioChart,
            'label' => ['Heart Rate', 'Bp Systolic', 'Bp Diastolic', 'Capillary Refill Time', 'CVP', 'MAP', 'Peripheral Pulses', 'Rhythm', 'Respiratory Rate', 'Temperature', 'Sp02', 'Recorded by']
                        ], 200);

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
    public function newShowRespiratory(PatientCare $patientCare, $active_day)
    {
         $resp_reading = RespiratoryAssessment::where('patient_care_id', $patientCare->id)
                        ->whereDate('created_at', Carbon::parse($active_day))
                        ->orderBy('created_by')
                        ->get();
        $resp_group = $resp_reading->groupBy(function(RespiratoryAssessment $item) {
            return $item->created_at->format('d/m/Y h:i:s A');
        });

        $resp_chart = [];

        //select the last two grouping in $cardio_reading
        $lastTwoGroups = $resp_group->slice(-2);

        foreach($lastTwoGroups as $index => $values)
        {
            foreach($values as $value)
            {
                $resp_chart['label'][] = $index;
                $resp_chart['ModeofVentilation'][] =$value->mode_of_ventilation ?? '--';
                $resp_chart['IERation'][] = $value->i_e_ration ?? '--';
                $resp_chart['FiO2'][] = $value->fi02 ?? '--';
                $resp_chart['PEEP'][] = $value->peep ?? '--';
                $resp_chart['TidalVolume'][] = $value->patient_tidal_volume ?? '--';
                $resp_chart['VentilatorSetting'][] =$value->ventilator_set_rate ?? '--';
                $resp_chart['RespiratoryEffort'][] = $value->respiratory_effort ?? '--';
                $resp_chart['EndothrachealIntubation'][] = $value->endothracheal_intubation ?? '--';
                $resp_chart['PressureSupport'][] = $value->pressure_support ?? '--';
                $resp_chart['RecordedBy'][] = $value->createdBy->fullname ?? '--';
            }
        }

        return response(['data' =>$resp_chart,
                        'label' => ['Mode of Ventilation', 'I E Ration','FiO2','PEEP','Tidal Volume', 'Ventilator Setting', 'Respiratory Effort', 'Endothracheal Intubation','Pressure Support','Recorded By']
    ], 200);

    }
    public function storeFluid(Request $request)
    {
         $data = $request->all();
         // dd($data);
         $created_at = now();
        foreach($data['fluid_name'] as $key => $fluid)
        {
            $fluidRecord = FluidBalance::create([
                'patient_care_id' => $data['patient_care_id'],
                'fluid' => $data["fluid_name"][$key],
                'volume' => $data['fluid_volume'][$key],
                'direction' => $data['fluid_direction'][$key],
                'hour_taken' =>$created_at,
                'created_by' => Auth::user()->id,
                'time_of_fluid_balance' => $created_at,
            ]);
        }



        return response(['message'=> 'Fluid Reading Added successfully'], 200);
    }

    public function showFluid(PatientCare $patientCare,$active_day)
    {

        $groupedFluid = FluidBalance::where('patient_care_id', $patientCare->id)
                        ->whereDate('created_at', Carbon::parse($active_day))
                        ->orderBy('hour_taken')
                        ->get();

        $groupedInputFluid = $groupedFluid
                        ->where('direction', 'input')
                        ->groupBy(function(FluidBalance $item) {
                            return $item->hour_taken->format('H:i A');
                        });
        $groupedOutputFluid = $groupedFluid->where('direction', 'output')
                        ->groupBy(function(FluidBalance $item) {
                            return $item->hour_taken->format('H:i A');
                        });
        $allfluids = FluidBalance::where('patient_care_id', $patientCare->id)
                        ->get();
        $inputNumbers = $allfluids->where('direction', 'input')->unique('fluid')->count();
        $outputNumbers = $allfluids->where('direction', 'output')->unique('fluid')->count();
        $outputFluids = $allfluids->where('direction', 'output')->unique('fluid')->pluck('fluid')->toArray();
        $inputFluids = $allfluids->where('direction', 'input')->unique('fluid')->pluck('fluid');

       // To use the grouped users array:
       $results = [];
       foreach($groupedInputFluid as $key => $value)
       {
              $results['label'][] = $key;

                // $results['fluids'][] = $value->pluck('volume')->toArray();
                $presentFluids = $value->pluck('fluid')->toArray();
                $presntVolumes = $value->pluck('volume')->toArray();
                $inputFluidsVol =[];
                foreach($inputFluids as $key=>$inputFluid)
                {
                    if(in_array($inputFluid, $presentFluids))
                    {
                        $inputFluidsVol[] = $presntVolumes[array_search($inputFluid, $presentFluids)];
                    }else{
                        $inputFluidsVol[] = 0;
                    }

                }
                $results['fluids'][] =Arr::flatten($inputFluidsVol);
                // Arr::map($inputFluidsVol, function($value, $key) use (&$results){
                //     $results['fluids'][] = $value;
                // });
                $results['created_by'][] = $value[0]->createdBy->fullname;
        }
        $resultsOutput = [];
        foreach($groupedOutputFluid as $key => $outputvalue)
        {
              $resultsOutput['label'][] = $key;

                // $results['fluids'][] = $value->pluck('volume')->toArray();
                $presentFluids = $outputvalue->pluck('fluid')->toArray();
                $presntVolumes = $outputvalue->pluck('volume')->toArray();
                $outputFluidsVol =[];
                foreach($outputFluids as $key=>$outputFluid)
                {
                    if(in_array($outputFluid, $presentFluids))
                    {
                        $outputFluidsVol[] = $presntVolumes[array_search($outputFluid, $presentFluids)];
                    }else{
                        $outputFluidsVol[] = 0;
                    }

                }
                $resultsOutput['fluids'][] =Arr::flatten($outputFluidsVol);
                $resultsOutput['cretead_by'][] = $value[0]->createdBy->fullname;
        }




        return response(['data' => $results,
                        'outputData' => $resultsOutput,
                        'outputFluids' => $outputFluids,
                        'inputFluids' => $inputFluids,
                        'outputNumbers' => $outputNumbers,
                        'inputNumbers' => $inputNumbers
                        ], 200);


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
            return $item->hour_taken->format('H:i A');
        });
        $medication_names = $patientCare->medications->unique('medication')->pluck('medication')->toArray();
        $medication_count = count($medication_names);
        // dump($fluid_names);
        $medication_chart = [];
        foreach($medication_group as $key => $value)
        {
            $medication_chart['label'][] = $key;
            $presentMedications = $value->pluck('medication')->toArray();
            $presentDosages = $value->pluck('dosage')->toArray();
            $medication_dosages = [];
            foreach($medication_names as $medication_name)
            {
                if(in_array($medication_name, $presentMedications))
                {
                    $medication_dosages[] = $presentDosages[array_search($medication_name, $presentMedications)];
                }else{
                    $medication_dosages[] = 0;
                }
            }
            $medication_chart['medications'][] = Arr::flatten($medication_dosages);
            $medication_chart['created_by'][] = $value[0]->createdBy->fullname;
        }


        return response(['data' => $medication_chart,
                        'medication_names' => $medication_names,
                        'medication_count' => $medication_count
                        ], 200);

    }
    public function storeMedication(Request $request)
    {
        $data= $request->all();
         $created_at = now();
       foreach($data['medication_name'] as $key => $medication)
       {
                 $medicationRecord = Medication::create([
                'patient_care_id' => $data['patient_care_id'],
                'medication' => $data['medication_name'][$key],
                'dosage' => $data['medication_dose'][$key],
                'frequency' => $data['frequency'],
                'created_by' => Auth::user()->id,
                'hour_taken' => $created_at,
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
            return $item->hour_taken->format('H:i A');
        });
        $nutrition_names = $patientCare->nutritions->unique('feeding_route')->pluck('feeding_route')->toArray();
        // dump($nutrition_names);
        $nutrition_count = count($nutrition_names);

        $nutrition_chart = [];
        foreach($nutrition_group as $key => $value)
        {
            $nutrition_chart['label'][] = $key;
            $presentNutritions = $value->pluck('feeding_route')->toArray();
            $presentCalories = $value->pluck('caloric_intake')->toArray();
            $nutrition_calories = [];
            foreach($nutrition_names as $nutrition_name)
            {
                if(in_array($nutrition_name, $presentNutritions))
                {
                    $nutrition_calories[] = $presentCalories[array_search($nutrition_name, $presentNutritions)];
                }else{
                    $nutrition_calories[] = 0;
                }
            }
            $nutrition_chart['nutrition'][] = Arr::flatten($nutrition_calories);
            $nutrition_chart['created_by'][] = $value[0]->createdBy->fullname;
        }
        // dump($nutrition_group);


            return response(['data' => $nutrition_chart,
                            'nutrition_names' => $nutrition_names,
                            'nutrition_count' => $nutrition_count
                            ], 200);

    }
    public function storeNutrition(Request $request)
    {
        $data= $request->all();
        $created_at = now();
        foreach($data['nutrition_name'] as $key => $nutrition)
         {
             $medicationRecord = Nutrition::create([
                'patient_care_id' => $data['patient_care_id'],
                'feeding_route' => $data['nutrition_name'][$key],
                'caloric_intake' => $data['nutrition_dose'][$key],

                'created_by' => Auth::user()->id,
                'hour_taken' => $created_at,
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
            'created_by' => Auth::user()->id,
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
            // dump($reading->eyes_open);
            $neuro_chart['Eyes Open'][] = $this->processEyeOpenEnum($reading->eyes_open->value);
            $neuro_chart['Sedated'][] = $reading->sedated ? 'True' : 'False';
            $neuro_chart['Intubated'][] = $reading->intubated ? 'True' : 'False';
            $neuro_chart['Best Motor Response'][] = $this->processMotorResponseEnum($reading->best_motor_response->value);
            $neuro_chart['Best Verbal Response'][] = $this->processVerbalCommandEnum($reading->best_verbal_response->value);
            $neuro_chart['sedation_score'][] = $this->processSwdationScoreEnum($reading->sedation_score);
            $neuro_chart['pupil_diameter'][] = $reading->pupil_diameter;
            $neuro_chart['hour_taken'][] = $reading->hour_taken->format('H:i a');
            $neuro_chart['Created by'][] = $reading->createdBy->fullname;

        }
        return response($neuro_chart, 200);
    }

    public function processEyeOpenEnum($eyeopen)
    {
        return match($eyeopen){
            4 => 'Spontaneously',
            3 => 'To Verbal Command',
            2 => 'To Pain',
            1 => 'No Response',
        };
    }

    public function processVerbalCommandEnum($verbalcommand)
    {
        return match($verbalcommand){
            1 => 'No Response',
            2 => 'Incomprehensible Sound',
            3 => 'Inappropriate Words',
           4 => 'Disoriented Converses',
            5=> 'Orientated Converses',
        };
    }
    public function processSwdationScoreEnum($sedation)
    {
        return match($sedation){
           1 => 'Anxious , Agitated or Restless or Both',
            2 => 'Cooperative, oriented & Tranquil',
           3 => 'Response To Command',
            4 => 'Asleep but Brisk, response to glabellar tap',
            5 => 'Asleep Sluggish response to glabellar tap',
            6 => 'No Response',
        };
    }

    public function processMotorResponseEnum($motorresponse)
    {
        return match($motorresponse){
           6 => 'Obeys Commands',
           5 => 'Localise Pain',
           4 => 'Flexion Withdrawal',
           3 => 'Flexion Abnormal',
           2 => 'Extention to Pain',
           1 => 'None',
        };
    }
}
