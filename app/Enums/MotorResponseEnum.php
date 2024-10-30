<?php

namespace App\Enums;

use App\Attributes\Description;
use App\Traits\AttributableEnum;
use Illuminate\Contracts\Support\DeferringDisplayableValue;

enum MotorResponseEnum: int implements DeferringDisplayableValue
{
    use AttributableEnum;

   #[Description('Obeys Commands')]
   case ObeysCommands = 6;
   #[Description('Localise Pain')]
   case LocalisePain = 5;
   #[Description('Flexion Withdrawal')]
   case FlexionWithdrawal = 4;
   #[Description('Flexion Abnormal')]
   case FlexionAbnormal = 3;
   #[Description('Extention to Pain')]
   case ExtentionToPain = 2;
   #[Description('None')]
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
