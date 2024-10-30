<?php

namespace App\Enums;

use App\Attributes\Description;
use App\Traits\AttributableEnum;
use Illuminate\Contracts\Support\DeferringDisplayableValue;

enum VerbalResponseEnum: int implements DeferringDisplayableValue
{
    use AttributableEnum;


    #[Description('No Response')]
    case NoResponse = 1;
    #[Description('Incomprehensible Sound')]
    case IncomprehensibleSound = 2;
    #[Description('Inappropraite Words')]
    case InappropriateWords = 3;
    #[Description('Disoriented Converses')]
    case DisorientedConverses = 4;
    #[Description('Orientated Converses')]
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
