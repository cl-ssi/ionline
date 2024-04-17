<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resources\Mobile;
use App\Models\User;

class MobileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $mobile = New Mobile();
      $mobile->brand = "Motorola";
      $mobile->model = "x4";
      $mobile->number = "789456132";
      $mobile->user()->associate(User::find(15287582));
      $mobile->save();
    }
}
