<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
      $dataSet[] = ['user_id' => Auth()->user()->id, 'name' => $val['name']];
    }

    foreach ($dataSet as $item) {
      Collection::where('user_id',$item['user_id'])->where('name', $item['name'])->firstOr(function () use($item){
        return Collection::updateOrCreate($item);
       });
    }
  }
}
