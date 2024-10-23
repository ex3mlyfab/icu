<?php

namespace App\Enums;

enum VerbalResponseEnum: int
{
    case NoResponse = 1;
    case IncomprehensibleSound = 2;
    case InappropriateWords = 3;
    case DisorientedConverses = 4;
    case OrientatedConverses = 5;
}
