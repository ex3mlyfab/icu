<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicationRequest extends FormRequest
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
            //
            'patient_care_id' => 'required',
            'medication_select' => 'required',
            'dosage' => 'required',
            'medication_name' => 'required_if:medication_select,others',
            'hour_taken' => 'required',
            'frequency' => 'required',
        ];
    }
}
