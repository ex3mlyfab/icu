<?php

namespace App\Models;

use App\Enums\GenderEnum;
use App\Enums\MaritalStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Patient extends Model
{
    use HasFactory;
     protected $guarded = ['id'];
     protected $casts = [
         'date_of_birth' => 'date',
         'gender' =>GenderEnum::class,
         'marital_status' =>MaritalStatusEnum::class

     ];

     public function patientCares(): HasMany
     {
        return $this->hasMany(PatientCare::class);
     }

     public function latestPatientCare(): HasOne
     {
        return $this->hasOne(PatientCare::class)->latestOfMany();
     }
    public function getFullnameAttribute()
    {
        return ucwords( $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name);
    }
    }
