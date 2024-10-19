<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class PatientCare extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
       'admission_date' => 'datetime',
       'discharge_date' => 'datetime',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
    public function bedModel(): BelongsTo
    {
        return $this->belongsTo(BedModel::class);
    }
    public function bedOccupationHistory(): HasOne
    {
        return $this->hasOne(BedOccupationHistory::class);
    }

    public function bloodGases(): HasMany
    {
        return $this->hasMany(BloodGas::class);
    }



    public function bowelOutputs(): HasMany
    {
        return $this->hasMany(BowelOutput::class);
    }

    public function cardioAssessments(): HasMany
    {
        return $this->hasMany(CardioAssessment::class);
    }

    public function sedationScores(): HasMany
    {
        return $this->hasMany(SedationScore::class);
    }

    public function consultantComments(): HasMany
    {
        return $this->hasMany(ConsultantComment::class);
    }

    public function respiratoryAssessments(): HasMany
    {
        return $this->hasMany(RespiratoryAssessment::class);
    }

    public function dailyNotes(): HasMany
    {
        return $this->hasMany(DailyNote::class);
    }
    public function dailyTreatmentPlans(): HasMany
    {
        return $this->hasMany(DailyTreatmentPlan::class);
    }
    public function fluidBalances(): HasMany
    {
        return $this->hasMany(FluidBalance::class);
    }

    public function labResults(): HasMany
    {
        return $this->hasMany(LabResult::class);
    }
    public function handOverChecklists(): HasMany
    {
        return $this->hasMany(HandOverChecklist::class);
    }

    public function infusionandRates(): HasMany
    {
        return $this->hasMany(InfusionAndRate::class);
    }
    public function invasiveLines():HasMany
    {
        return $this->hasMany(InvasiveLine::class);
    }

    public function medications(): HasMany
    {
        return $this->hasMany(Medication::class);
    }

    public function neuroAssessments(): HasMany
    {
        return $this->hasMany(NeuroAssessment::class);
    }
    public function nutritions(): HasMany
    {
        return $this->hasMany(Nutrition::class);
    }
    public function renalAssessments(): HasMany
    {
        return $this->hasMany(RenalAssessment::class);
    }
    public function seizureCharts(): HasMany
    {
        return $this->hasMany(SeizureChart::class);
    }

    public function skinWoundCares(): HasMany
    {
        return $this->hasMany(SkinWoundCare::class);
    }
}
