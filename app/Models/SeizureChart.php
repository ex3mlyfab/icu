<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeizureChart extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'datetime',
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
