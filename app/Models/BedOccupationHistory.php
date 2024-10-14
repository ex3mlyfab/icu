<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BedOccupationHistory extends Model
{
    use HasFactory;
     protected $guarded = ['id'];

    public function bed():BelongsTo
    {
        return $this->belongsTo(BedModel::class);
    }

    public function patient():BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
