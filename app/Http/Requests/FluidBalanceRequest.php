<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FluidBalanceRequest extends FormRequest
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
            'fluid_select'=> 'required',
            'patient_care_id' => 'required',
            'fluid_name' => 'required_if:fluid_select,others',
            'volume' => 'required|numeric',
            'direction' => 'required_if:fluid_select,others',
            'hour_taken' => 'required',
        ];
    }
}
