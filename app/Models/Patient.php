<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Patient extends Model
{
    use HasFactory;
     protected $guarded = ['id'];

     public function patientCares(): HasMany
     {
        return $this->hasMany(PatientCare::class);
     }

     public function patientCareLatest()
     {
        return $this->patientCares()->latest();
    }
    public function getFullnameAttribute()
    {
        return ucwords( $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name);
    }
    }
