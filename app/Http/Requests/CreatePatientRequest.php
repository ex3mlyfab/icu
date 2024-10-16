<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePatientRequest extends FormRequest
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
            'first_name' => 'required|min:2|string',
            'last_name' => 'required|string|min:2',
            'middle_name' => 'nullable',
            'hospital_no' => 'nullable|string|min:2',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'marital_status' => 'required',
            'tribe' => 'required|string|min:2',
            'address' => 'required|string|min:2',
            'telephone' => 'required|string|min:10',
            'occupation' => 'required|string|min:2',
            'next_of_kin' => 'required|string|min:2',
            'next_of_kin_address' => 'required|string|min:2',
            'next_of_kin_telephone' => 'required|string|min:10',
            'next_of_kin_relationship' => 'required|string|min:2',
            'hometown' => 'required|string|min:2',
            'state_of_origin' => 'required|string|min:2',
            'religion' => 'required',
            'condition' => 'required',
            'diagnosis' => 'required',
            'admission_date' => 'required',
            'icu_consultant'=> 'nullable',
            'nurse_incharge' => 'required',
            'admitted_from' => 'required',
            'bed_model_id' => 'required',
        ];
    }
}
