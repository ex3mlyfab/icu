<?php

namespace App\Enums;

enum SedationScoreEnum: int
{
    case Anxious = 1;
    case Cooperative = 2;
    case ResponseToCommand = 3;
    case AsleepButBrisk = 4;
    case AsleepButSluggish = 5;
    case NoResponse = 6;

}
