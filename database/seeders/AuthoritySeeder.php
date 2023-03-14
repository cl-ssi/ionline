<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Rrhh\Authority;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AuthoritySeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */

    public function run()
    {

        // Define la fecha de inicio y finalización del período de un año.
        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addYear();

        // Crea un período que contenga cada día en el intervalo especificado.
        $period = CarbonPeriod::create($startDate, $endDate);


        foreach ($period as $date) {

            Authority::create([
                'user_id' => '12345678',
                'date' => $date,
                'position' => 'Subdirectora',
                'type' => 'manager',
                'decree' => 'resol. pendiente',
                'organizational_unit_id' => '1',
                'creator_id' => '12345678',
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);

            Authority::create([
                'user_id' => '15287582',
                'date' => $date,
                'position' => 'Director',
                'type' => 'manager',
                'organizational_unit_id' => '1',
                'creator_id' => '15287582',
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);

            Authority::create([
                'user_id' => '15287582',
                'date' => $date,
                'position' => 'Jefe',
                'type' => 'manager',
                'organizational_unit_id' => '2',
                'creator_id' => '15287582',
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);

            Authority::create([
                'user_id' => '15287582',
                'date' => $date,
                'position' => 'Jefe',
                'type' => 'manager',
                'organizational_unit_id' => '24',
                'creator_id' => '15287582',
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);

            Authority::create([
                'user_id' => '15287582',
                'date' => $date,
                'position' => 'Jefe',
                'type' => 'manager',
                'organizational_unit_id' => '40',
                'creator_id' => '15287582',
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);

            Authority::create([
                'user_id' => '15287582',
                'date' => $date,
                'position' => 'Jefe',
                'type' => 'manager',
                'organizational_unit_id' => '44',
                'creator_id' => '15287582',
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);

            Authority::create([
                'user_id' => '15287582',
                'date' => $date,
                'position' => 'Jefe',
                'type' => 'manager',
                'organizational_unit_id' => '59',
                'creator_id' => '15287582',
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);

            Authority::create([
                'user_id' => '15287582',
                'date' => $date,
                'position' => 'Subdirector',
                'type' => 'manager',
                'organizational_unit_id' => '1',
                'creator_id' => '15287582',
                'created_at' => carbon::now(),
                'updated_at' => carbon::now()
            ]);
        }
    }
}
