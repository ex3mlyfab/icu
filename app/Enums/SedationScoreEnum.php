<?php

namespace App\Enums;

use Illuminate\Contracts\Support\DeferringDisplayableValue;

enum SedationScoreEnum: int implements DeferringDisplayableValue
{
    case Anxious = 1;
    case Cooperative = 2;
    case ResponseToCommand = 3;
    case AsleepButBrisk = 4;
    case AsleepButSluggish = 5;
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
