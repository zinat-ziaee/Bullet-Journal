<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class CollectionsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $dataSet = [];
    foreach (collect(config::get('settings.fixed_collections')) as $key => $val) {
      $dataSet[] = [
        'user_id' => auth()->id(),
        'name' => $val['name'],
        'is_fixed' => true,
      ];
    }

    foreach ($dataSet as $item) {
      Collection::where('user_id',$item['user_id'])->where('name', $item['name'])->firstOr(function () use($item){
        return Collection::updateOrCreate($item);
       });
    }
  }
}
