<?php

use App\Holiday;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $holiday = Holiday::Create(['date'=>'2018-01-01', 'name'=>'Año nuevo']);
        $holiday = Holiday::Create(['date'=>'2018-03-30', 'name'=>'Viernes santo']);
        $holiday = Holiday::Create(['date'=>'2018-05-31', 'name'=>'Sábado santo']);
        $holiday = Holiday::Create(['date'=>'2018-05-01', 'name'=>'Día nacional del trabajo']);
        $holiday = Holiday::Create(['date'=>'2018-05-21', 'name'=>'Día de las glorias navales']);
        $holiday = Holiday::Create(['date'=>'2018-07-02', 'name'=>'San Pedro y San Pablo']);
        $holiday = Holiday::Create(['date'=>'2018-07-16', 'name'=>'Día de la virgen del Cármen']);
        $holiday = Holiday::Create(['date'=>'2018-08-10', 'name'=>'San Lorenzo', 'region'=>'I']);
        $holiday = Holiday::Create(['date'=>'2018-08-15', 'name'=>'Asunción de la virgen']);
        $holiday = Holiday::Create(['date'=>'2018-09-17', 'name'=>'Fiestas patrias']);
        $holiday = Holiday::Create(['date'=>'2018-09-18', 'name'=>'Independencia']);
        $holiday = Holiday::Create(['date'=>'2018-09-19', 'name'=>'Glorias del ejercito']);
        $holiday = Holiday::Create(['date'=>'2018-10-15', 'name'=>'Encuentro de dos mundos']);
        $holiday = Holiday::Create(['date'=>'2018-11-01', 'name'=>'Todos los santos']);
        $holiday = Holiday::Create(['date'=>'2018-11-02', 'name'=>'Iglesias evangelicas y protestantes']);
        $holiday = Holiday::Create(['date'=>'2018-12-08', 'name'=>'Inmaculada concepción']);
        $holiday = Holiday::Create(['date'=>'2018-12-25', 'name'=>'Navidad']);
    }
}
