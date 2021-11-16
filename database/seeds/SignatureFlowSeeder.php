<?php

use Illuminate\Database\Seeder;
use App\Models\ServiceRequest\SignatureFlow;
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
        SignatureFlow::create([
            'ou_id' => '20',
            'responsable_id' => '12345678',
            'service_request_id' => '1',
            'sign_position' => '1',
            'type' => 'Responsable',
            'employee' => 'Administrator',
            'signature_date' => carbon::now(),
            'status' => '1',
            'user_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);
        
        SignatureFlow::create([
            'ou_id' => '20',
            'responsable_id' => '12345678',
            'service_request_id' => '1',
            'sign_position' => '2',
            'type' => 'Supervisor',
            'employee' => 'Administrator',
            'user_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

        SignatureFlow::create([
            'ou_id' => '1',
            'responsable_id' => '15287582',
            'service_request_id' => '1',
            'sign_position' => '3',
            'type' => 'visador',
            'employee' => 'Director',
            'user_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

        SignatureFlow::create([
            'ou_id' => '1',
            'responsable_id' => '15287582',
            'service_request_id' => '1',
            'sign_position' => '4',
            'type' => 'visador',
            'employee' => 'Director',
            'user_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

        SignatureFlow::create([
            'ou_id' => '1',
            'responsable_id' => '15287582',
            'service_request_id' => '1',
            'sign_position' => '5',
            'type' => 'visador',
            'employee' => 'Director',
            'user_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

        SignatureFlow::create([
            'ou_id' => '1',
            'responsable_id' => '15287582',
            'service_request_id' => '1',
            'sign_position' => '6',
            'type' => 'visador',
            'employee' => 'Director',
            'user_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

        SignatureFlow::create([
            'ou_id' => '1',
            'responsable_id' => '15287582',
            'service_request_id' => '1',
            'sign_position' => '7',
            'type' => 'visador',
            'employee' => 'Director',
            'user_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);
    }
}
