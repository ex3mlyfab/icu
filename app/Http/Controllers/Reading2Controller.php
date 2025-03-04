<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabResultRequest;
use App\Models\DailyNote;
use App\Models\DailyTreatmentPlan;
use App\Models\FluidBalance;
use App\Models\InvasiveLine;
use App\Models\LabResult;
use App\Models\PatientCare;
use App\Models\PhysicianOrder;
use App\Models\ProgressNote;
use App\Models\SeizureChart;
use App\Models\SkinWoundCare;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
            $item->new_date = $item->date->format('d-m-Y');
            $item->recorded_by = $item->createdBy->fullname;
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
            $item->recorded_by = $item->createdBy->fullname;
            return $item;
        });
        return response($labs, 200);
    }

    public function storeSkinCare(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $data['created_by'] = Auth::user()->id;
        $data['date_of_care'] = now();

        SkinWoundCare::create($data);

        return response(['message'=> 'Skin Care Added successfully'], 200);
    }

    public function showSkinCare(PatientCare $patientCare)
    {
        $labs = SkinWoundCare::where('patient_id_care', $patientCare->id)
        ->get();

        $labs = $labs->map(function($item) {

            $item->new_date = $item->date_of_care->format('d-m-Y h:i a');
            $item->recorded_by = $item->createdBy->fullname;
            return $item;
        });
        return response($labs, 200);
    }
    public function storeDailyNote(Request $request)
    {
        $data = $request->all();

        $data['created_by'] = Auth::user()->id;
        $data['time_of_daily_notes'] = now();

        DailyNote::create($data);

        return response(['message'=> 'Daily Note Added successfully'], 200);
    }

    public function showDailyNote(PatientCare $patientCare, $active_day, $viewtype)
    {
        $labs = DailyNote::where('patient_care_id', $patientCare->id)
        ->whereDate('created_at', Carbon::parse($active_day))
        ->get();

        $labs = $labs->map(function($item) {

            $item->new_date = $item->time_of_daily_notes->format('d-m-Y h:i a');
            $item->recorded_by = $item->createdBy->fullname;
            return $item;
        });

       return response($labs, 200);
    }

    public function storeDailyTreatment(Request $request)
    {
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        $data['date_of_treatment'] = now();

        ProgressNote::create($data);

        return response(['message'=> 'Daily Treatment Added successfully'], 200);
    }

    public function showDailyTreatment(PatientCare $patientCare, $active_day)
    {
        $labs = ProgressNote::where('patient_care_id', $patientCare->id)
        ->whereDate('created_at', Carbon::parse($active_day))
        ->get();

         $labs = $labs->map(function($item) {

            $item->new_date = $item->created_at->format('d-m-Y h:i a');
            $item->recorded_by = $item->createdBy->fullname;
            return $item;
        });
        return response($labs, 200);
    }
    public function storePhysicianNote(Request $request)
    {
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;

        PhysicianOrder::create($data);

        return response(['message'=> 'Physician Note Added successfully'], 200);
    }

    public function showPhysicianNote(PatientCare $patientCare, $active_day, $viewtype)
    {
        $labs = PhysicianOrder::where('patient_care_id', $patientCare->id)
        ->whereDate('created_at', Carbon::parse($active_day))
        ->get();

         $labs = $labs->map(function($item) {
            $item->new_date = $item->created_at->format('h:i a');
            $item->recorded_by = $item->createdBy->fullname;
            return $item;
        });

        return response($labs, 200);
    }
    public function renalFluid(PatientCare $patientCare, $active_day)
    {
        $labs = FluidBalance::where('patient_care_id', $patientCare->id)
        ->whereDate('created_at', Carbon::parse($active_day))
        ->get();
         $fluid_names = $patientCare->fluidBalances->unique('fluid')->pluck('fluid')->toArray();
        $fluid_balance = [];

        foreach($fluid_names as $fluid)
        {
            $fluid_balance[$fluid] = $labs->where('fluid', $fluid)->sum('volume');

        }
        $fluid_balance['Total Input'] = $labs->where('direction', 'input')->sum('volume');
        $fluid_balance['Total Output'] = $labs->where('direction', 'output')->sum('volume');


        return response($fluid_balance, 200);
    }
    public function dischargePatient(Request $request)
    {
        $patientCare = PatientCare::find($request->patient_care_id);
        // dd($patientCare);
        $patientCare->update(['ready_for_discharge' => 1,
        'discharge_date' => $request->discharge_date,
        'notes' => $request->notes,
        // 'discharge_type' => $request->discharge_type
    ]);
    $patientCare->bedModel()->update(['is_active' => 0]);

    $patientCare->bedOccupationHistory()->update(['is_occupied' => 0,
'end_date' => $request->discharge_date]);

        return redirect(route('dashboard'));
    }
    public function fluidChart(PatientCare $patientCare, $active_day)
    {
        $groupedFluid = FluidBalance::where('patient_care_id', $patientCare->id)
                        ->whereDate('created_at', Carbon::parse($active_day))
                        ->orderBy('hour_taken')
                        ->get();
        $allfluids = FluidBalance::where('patient_care_id', $patientCare->id)
                        ->get();

        $gFluid = $groupedFluid
                        ->groupBy(function(FluidBalance $item) {
                            return $item->hour_taken->format('H:i A');
                        });
        $inputFluids = $allfluids->unique('fluid')->pluck('fluid');
        $results = [];
        foreach($gFluid as $key => $value)
        {
            $results['label'][] = $key;
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

        }
        return response(['data' =>$results,
                        'allFluids' =>$inputFluids ], 200);
    }
}
