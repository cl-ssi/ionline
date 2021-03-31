<?php

// namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rrhh\ShiftTypes;

class ShiftTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShiftTypes::Create(["name"=>"Turno A", "shortname"=>"TA","day_series"=>"F,L,L,N,N,F,F","status"=>1]);
        ShiftTypes::Create(["name"=>"Turno B", "shortname"=>"TB","day_series"=>"N,F,F,L,L,N,N","status"=>1]);
        ShiftTypes::Create(["name"=>"Turno C", "shortname"=>"TC","day_series"=>"L,N,N,F,F,L,L","status"=>1]);
        ShiftTypes::Create(["name"=>"Turno Diurno", "shortname"=>"TDiu","day_series"=>"D,D,D,D,D,F,F","status"=>1]);
    }
}
