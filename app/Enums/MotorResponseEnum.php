<?php

namespace App\Enums;

use Illuminate\Contracts\Support\DeferringDisplayableValue;

enum MotorResponseEnum: int implements DeferringDisplayableValue
{
   case ObeysCommands = 6;
   case LocalisePain = 5;
   case FlexionWithdrawal = 4;
   case FlexionAbnormal = 3;
   case ExtentionToPain = 2;
   case None =1;

   public function resolveDisplayableValue(): string
   {
     return match ($this) {
           self::ObeysCommands => 'Obeys Commands',
           self::LocalisePain => 'Localise Pain',
           self::FlexionWithdrawal => 'Flexion Withdrawal',
           self::FlexionAbnormal => 'Flexion Abnormal',
           self::ExtentionToPain => 'Extention to Pain',
           self::None => 'None',
       };
   }
}
