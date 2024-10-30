<?php

namespace App\Enums;
use App\Attributes\Description;
use App\Traits\AttributableEnum;
use Illuminate\Contracts\Support\DeferringDisplayableValue;

enum EyesOpenEnum: int implements DeferringDisplayableValue
{
    use AttributableEnum;

    #[Description('Spontaneously')]
    case Spontaneously = 4;
    #[Description('To Verbal Command')]
    case ToVerbalCommand = 3;
    #[Description('To Pain')]
    case ToPain = 2;
    #[Description('No Response')]
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


