<?php

namespace App\Enums;

use Illuminate\Contracts\Support\DeferringDisplayableValue;

enum EyesOpenEnum: int implements DeferringDisplayableValue
{
    case Spontaneously = 4;
    case ToVerbalCommand = 3;
    case ToPain = 2;
    case NoResponse = 1;

    public function resolveDisplayableValue() :string
    {
        return match ($this) {
            self::Spontaneously => 'Spontaneously',
            self::ToVerbalCommand => 'To Verbal Command',
            self::ToPain => 'To Pain',
            self::NoResponse => 'No Response',
        };
    }
}


