<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientCare extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
       'admission_date' => 'datetime',
       'discharge_date' => 'datetime',
    ];
    

}
