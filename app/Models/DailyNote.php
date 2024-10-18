<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyNote extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function patientCare(): BelongsTo
    {
        return $this->belongsTo(PatientCare::class);
    }
}
