<?php

use Illuminate\Database\Seeder;
use App\Resources\Printer;

class PrinterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $printer = new Printer();
      $printer->brand = 'HP';
      $printer->model = '1212';
      $printer->type = 'printer';
      $printer->ip = '10.8.226.31';
      $printer->save();

      $printer = new Printer();
      $printer->brand = 'Xerox';
      $printer->model = '3550';
      $printer->type = 'printer';
      $printer->ip = '10.8.226.32';
      $printer->save();

      $printer = new Printer();
      $printer->brand = 'Ricoh';
      $printer->model = 'xxx';
      $printer->type = 'printer';
      $printer->ip = '10.8.226.33';
      $printer->save();
    }
}
