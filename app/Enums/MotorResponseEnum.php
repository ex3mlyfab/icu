<?php

namespace App\Enums;

enum MotorResponseEnum: int
{
   case ObeysCommands = 6;
   case LocalisePain = 5;
   case FlexionWithdrawal = 4;
   case FlexionAbnormal = 3;
   case ExtentionToPain = 2;
   case None =1;
}
