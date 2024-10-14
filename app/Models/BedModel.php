<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BedModel extends Model
{
    use HasFactory;
     protected $guarded = ['id'];

     public function bedOccupationHistory(): HasMany
     {
        return $this->hasMany(BedOccupationHistory::class)->orderBy('created_at', 'desc');
     }

     public function bedOccupationHistoryLatest()
     {
        return $this->bedOccupationHistory()->latest();
     }

    public function getOccupancyAttribute()
    {
        return $this->bedOccupationHistoryLatest->is_occupied ?? 0;
    }

}
