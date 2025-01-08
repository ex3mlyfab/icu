<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RespiratoryAssessment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'hour_taken' => 'datetime:H:i',
        'time_of_respiratory_assessment' => 'datetime',
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
