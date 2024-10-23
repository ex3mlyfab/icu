<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NeuroAssessment extends Model
{
    use HasFactory;
     protected $guarded = ['id'];
     protected $casts = [
        'hour_taken' => 'datetime:H:i:s',
        'time_of_neuro_assessment' => 'datetime',
    ];

    public function patientCare(): BelongsTo
    {
        return $this->belongsTo(PatientCare::class);
    }
}
