<?php

use Illuminate\Database\Seeder;
use App\Resources\Computer;
use App\User;

class ComputerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $computer = new Computer();
      $computer->type = 'all-in-one';
      $computer->brand = 'LENOVO';
      $computer->model = 'v510z';
      $computer->serial = 'MP1A0M53';
      $computer->ip = '10.8.226.29';
      $computer->save();
      $computer->users()->attach(User::find(15287582));

      $computer = new Computer();
      $computer->type = 'all-in-one';
      $computer->brand = 'LENOVO';
      $computer->model = '00N1CB';
      $computer->serial = 'XXXXX';
      $computer->ip = '10.8.226.74';
      $computer->comment = 'Monitor adicional Samsung S19C150';
      $computer->save();
      $computer->users()->attach(User::find(16966444));

      $computer = new Computer();
      $computer->type = 'all-in-one';
      $computer->brand = 'OLIDATA';
      $computer->model = 'v510z';
      $computer->serial = 'XXXXX';
      $computer->ip = '10.8.226.124';
      $computer->save();

      $computer = new Computer();
      $computer->type = 'all-in-one';
      $computer->brand = 'LENOVO';
      $computer->model = 'v510z';
      $computer->serial = 'XXXXX';
      $computer->ip = '10.8.226.99';
      $computer->save();
    }
}
