<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardioAssessmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patient_care_id' => 'required',
            'heart_rate' => 'required|numeric',
            'blood_pressure_systolic' => 'required|numeric',
            'blood_pressure_diastolic' => 'required|numeric',
            'temperature'=> 'required|numeric',
            'respiratory_rate' => 'nullable|numeric',
            'spo2' => 'nullable|numeric',
            'map' => 'nullable|numeric',
            'cvp' =>  'nullable|numeric',
            'rhythm' => 'nullable|numeric',
            'peripheral_pulses' => 'nullable|numeric',
            'capillary_refill_time' => 'nullable|numeric',
            'hour_taken' => 'required',

        ];
    }
}
