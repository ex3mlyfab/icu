<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RespiRatoryAssessmentRequest extends FormRequest
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
            'mode_of_ventilation'=> 'required',
            'i_e_ration' => 'nullable',
            'fi02' => 'nullable',
            'peep' => 'nullable',
            'patient_tidal_volume' => 'nullable',
            'ventilator_set_rate' => 'nullable',
            'respiratory_effort' => 'nullable',
            'endothracheal_intubation' => 'nullable',
            'presuure_support' => 'nullable',
            'hour_taken' => 'required'
        ];
    }
}
