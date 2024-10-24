<?php

namespace App\Enums;

use Illuminate\Contracts\Support\DeferringDisplayableValue;

enum VerbalResponseEnum: int implements DeferringDisplayableValue
{
    case NoResponse = 1;
    case IncomprehensibleSound = 2;
    case InappropriateWords = 3;
    case DisorientedConverses = 4;
    case OrientatedConverses = 5;

    public function resolveDisplayableValue()
    {
        return match ($this) {
            self::NoResponse => 'No Response',
            self::IncomprehensibleSound => 'Incomprehensible Sound',
            self::InappropriateWords => 'Inappropriate Words',
            self::DisorientedConverses => 'Disoriented Converses',
            self::OrientatedConverses => 'Orientated Converses',
        };
    }
}
