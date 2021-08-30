<?php

namespace App\Helper;

class Helper
{
  public function getQuota($dividend, $divisor)
   {
     if($divisor == 0)
     {
       $quotient = 0;
     }
     else {
       $quotient = round(($dividend/$divisor)*100,2);
     }
     return $quotient;
   }

  public function startQueryLog()
  {
        \DB::enableQueryLog();
  }

  public function showQueries()
  {
       dd(\DB::getQueryLog());
  }

  public static function instance()
  {
      return new Helper();
  }
}
?>
