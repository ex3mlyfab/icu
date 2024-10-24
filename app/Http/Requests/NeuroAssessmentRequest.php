<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NeuroAssessmentRequest extends FormRequest
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
            'eyes_open' => 'required',
            'sedated' => 'nullable',
            'best_verbal_response' => 'required',
            'intubated' => 'nullable',
            'best_motor_response' => 'required',
            'muscle_relaxant' => 'nullable',
            'sedation_score' => 'required',
            'pupil_diameter' => 'nullable',
            'hour_taken' => 'required'
        ];
    }
}
