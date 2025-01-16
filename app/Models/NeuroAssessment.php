<?php

namespace App\Models;

use App\Enums\EyesOpenEnum;
use App\Enums\MotorResponseEnum;
use App\Enums\VerbalResponseEnum;
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
        'sedated' => 'boolean',
        'intubated' => 'boolean',
        'muscle_relaxant' => 'boolean',
        'eyes_open' => EyesOpenEnum::class,
        'best_motor_response' => MotorResponseEnum::class,
        'best_verbal_response' => VerbalResponseEnum::class,
        'Sedation_Score' => SedationScore::class,
    ];

    public function patientCare(): BelongsTo
    {
        return $this->belongsTo(PatientCare::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
