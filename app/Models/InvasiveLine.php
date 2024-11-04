<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvasiveLine extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'time_of_invasive_lines' => 'datetime',
    ];
    public function patientCare(): BelongsTo
    {
        return $this->belongsTo(PatientCare::class);
    }
}
