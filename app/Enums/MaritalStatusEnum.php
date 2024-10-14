<?php

namespace App\Enums;

enum MaritalStatusEnum: int
{
    case Married = 1;
    case Single = 2;
    case Widowed= 3;
    case Divorced = 4;
}