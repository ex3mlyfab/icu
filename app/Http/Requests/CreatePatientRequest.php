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
            'hospital_no' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'marital_status' => 'required',
            'religion' => 'required',
            'condition' => 'required',
            'diagnosis' => 'required',
            'icu_consultant'=> 'nullable',
            'nurse_incharge' => 'required',
            'admitted_from' => 'required',
        ];
    }
}
