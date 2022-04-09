<?php
namespace App\Util;

class ClearValue
{
  public static function clearPhone($phone){
    $phone = str_replace(" ", "", $phone);
    $phone = str_replace("-", "", $phone);
    $phone = str_replace("(", "", $phone);
    $phone = str_replace(")", "", $phone);
    return $phone;
  }
}
