<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BedModel extends Model
{
    use HasFactory;
     protected $guarded = ['id'];

     public function bedOccupationHistory(): HasMany
     {
        return $this->hasMany(BedOccupationHistory::class);
     }

     public function latestBedOccupationHistory(): HasOne
     {
        return $this->hasOne(BedOccupationHistory::class)->latestOfMany();
     }
     public function patientCare():BelongsTo
     {
        return $this->belongsTo(PatientCare::class);
     }
    
}
