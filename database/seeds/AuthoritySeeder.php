<?php //Laravel 8.x

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthoritySeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    private function create_table($id,$pos,$ouid)
    {
        $ID_Select = DB::table('users')->pluck('id');
        //$OUID_Select = collect(DB::table('organizational_units')->pluck('id'));

        DB::table('rrhh_authorities')->insert([
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
        DB::table('rrhh_authorities')->insert([
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

        AuthoritySeeder::create_table(15287582,'Director','1');
        AuthoritySeeder::create_table(15287582,'Jefe','2');
        AuthoritySeeder::create_table(15287582,'Jefe','24');
        AuthoritySeeder::create_table(15287582,'Jefe','40');
        AuthoritySeeder::create_table(15287582,'Jefe','44');
        AuthoritySeeder::create_table(15287582,'Jefe','59');
        AuthoritySeeder::create_table(15287582,'Subdirector','88');
        
    }
}
