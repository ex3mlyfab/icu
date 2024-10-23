<?php

namespace App\Enums;

enum EyesOpenEnum: int
{
    case Spontaneously = 4;
    case ToVerbalCommand = 3;
    case ToPain = 2;
    case NoResponse = 1;
}

