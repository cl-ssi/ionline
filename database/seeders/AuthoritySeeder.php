<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Rrhh\Authority;
use Carbon\Carbon;

class AuthoritySeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    
    public function run()
    {
        
        //DB::table('rrhh_authorities')->insert([
        Authority::create([
            'user_id' => '12345678',
            'from' => carbon::now()->toDateString(),
            'to' => carbon::now()->addYear()->toDateString(),
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
            'from' => carbon::now()->toDateString(),
            'to' => carbon::now()->addYear()->toDateString(),
            'position' => 'Director',
            'type' => 'manager',
            'organizational_unit_id' => '1',
            'creator_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

        Authority::create([
            'user_id' => '15287582',
            'from' => carbon::now()->toDateString(),
            'to' => carbon::now()->addYear()->toDateString(),
            'position' => 'Jefe',
            'type' => 'manager',
            'organizational_unit_id' => '2',
            'creator_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

        Authority::create([
            'user_id' => '15287582',
            'from' => carbon::now()->toDateString(),
            'to' => carbon::now()->addYear()->toDateString(),
            'position' => 'Jefe',
            'type' => 'manager',
            'organizational_unit_id' => '24',
            'creator_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

        Authority::create([
            'user_id' => '15287582',
            'from' => carbon::now()->toDateString(),
            'to' => carbon::now()->addYear()->toDateString(),
            'position' => 'Jefe',
            'type' => 'manager',
            'organizational_unit_id' => '40',
            'creator_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

        Authority::create([
            'user_id' => '15287582',
            'from' => carbon::now()->toDateString(),
            'to' => carbon::now()->addYear()->toDateString(),
            'position' => 'Jefe',
            'type' => 'manager',
            'organizational_unit_id' => '44',
            'creator_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

        Authority::create([
            'user_id' => '15287582',
            'from' => carbon::now()->toDateString(),
            'to' => carbon::now()->addYear()->toDateString(),
            'position' => 'Jefe',
            'type' => 'manager',
            'organizational_unit_id' => '59',
            'creator_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

        Authority::create([
            'user_id' => '15287582',
            'from' => carbon::now()->toDateString(),
            'to' => carbon::now()->addYear()->toDateString(),
            'position' => 'Subdirector',
            'type' => 'manager',
            'organizational_unit_id' => '1',
            'creator_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);
        
    }
}
