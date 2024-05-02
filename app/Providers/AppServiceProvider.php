<?php

namespace App\Providers;

use App\Models\NoteCategorize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    Model::unguard();

    if($this->app->environment('production')) {
      \URL::forceScheme('https');
    }
  }
}
