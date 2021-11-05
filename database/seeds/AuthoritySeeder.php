<?php

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
    
    private function insert_seed($id,$pos,$ouid)
    {
        $ID_Select = DB::table('users')->pluck('id');
        
        //DB::table('rrhh_authorities')->insert([
        Authority::create([
            'user_id' => $ID_Select[ $ID_Select->search($id) ],
            'from' => carbon::now()->toDateString(),
            'to' => carbon::now()->addYear()->toDateString(),
            'position' => $pos,
            'type' => 'manager',
            'organizational_unit_id' => $ouid,
            'creator_id' => $ID_Select[ $ID_Select->search($id) ],
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);
    }
    
    
    public function run()
    {
        
        //DB::table('rrhh_authorities')->insert([
        Authority::create([
            'user_id' => '13835321',
            'from' => carbon::now()->toDateString(),
            'to' => carbon::now()->addYear()->toDateString(),
            'position' => 'Subdirectora',
            'type' => 'manager',
            'decree' => 'resol. pendiente',
            'organizational_unit_id' => '85',
            'creator_id' => '12345678',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

        AuthoritySeeder::insert_seed(15287582,'Director','1');
        AuthoritySeeder::insert_seed(15287582,'Jefe','2');
        AuthoritySeeder::insert_seed(15287582,'Jefe','24');
        AuthoritySeeder::insert_seed(15287582,'Jefe','40');
        AuthoritySeeder::insert_seed(15287582,'Jefe','44');
        AuthoritySeeder::insert_seed(15287582,'Jefe','59');
        AuthoritySeeder::insert_seed(15287582,'Subdirector','88');
        
    }
}
