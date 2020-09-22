<?php

use Illuminate\Database\Seeder;
use App\Resources\Mobile;
use App\User;

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
