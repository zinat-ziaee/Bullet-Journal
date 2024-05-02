<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Morilog\Jalali\CalendarUtils;

class CarbonMacroServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    Carbon::macro('miladi', function ($date, $format = 'Y-m-d') {
      $dateString = CalendarUtils::convertNumbers($date, true);
      return CalendarUtils::createCarbonFromFormat($format, $dateString);
    });

    Carbon::macro('shamsi',function($data , $format = 'Y-m-d'){
      $date = CalendarUtils::strftime($format, strtotime($data)); // 1395-02-19
      return \Morilog\Jalali\CalendarUtils::convertNumbers($date); 
    });
  }
}
