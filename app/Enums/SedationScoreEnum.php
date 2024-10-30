<?php

namespace App\Enums;

use App\Attributes\Description;
use App\Traits\AttributableEnum;
use Illuminate\Contracts\Support\DeferringDisplayableValue;

enum SedationScoreEnum: int implements DeferringDisplayableValue
{
    use AttributableEnum;

    #[Description('Anxious, Agitated or Restless or Both')]
    case Anxious = 1;
    #[Description('Cooperative, oriented & Tranquil')]
    case Cooperative = 2;
    #[Description('Response To Command')]
    case ResponseToCommand = 3;
    #[Description('Asleep but Brisk, response to glabellar tap')]
    case AsleepButBrisk = 4;
    #[Description('Asleep Sluggish response to glabellar tap')]
    case AsleepButSluggish = 5;
    #[Description('No Response')]
    case NoResponse = 6;

    public function resolveDisplayableValue()
    {
        return match ($this) {
            self::Anxious => 'Anxious , Agitated or Restless or Both',
            self::Cooperative => 'Cooperative, oriented & Tranquil',
            self::ResponseToCommand => 'Response To Command',
            self::AsleepButBrisk => 'Asleep but Brisk, response to glabellar tap',
            self::AsleepButSluggish => 'Asleep Sluggish response to glabellar tap',
            self::NoResponse => 'No Response',
        };
    }



}
