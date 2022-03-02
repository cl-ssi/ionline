<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceRequests\SignatureFlow;
use Carbon\Carbon;

class SignatureFlowSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    
    public function run()
    {
        SignatureFlow::create([
            'ou_id' => '222',
            'responsable_id' => '15287582',
            'service_request_id' => '1',
            'sign_position' => '1',
            'type' => 'Responsable',
            'employee' => 'Profesional SIDRA',
            'signature_date' => carbon::now(),
            'status' => '1',
            'user_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

        SignatureFlow::create([
            'ou_id' => '222',
            'responsable_id' => '15287582',
            'service_request_id' => '1',
            'sign_position' => '2',
            'type' => 'Supervisor',
            'employee' => 'Profesional SIDRA',
            'status' => '1',
            'user_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

        SignatureFlow::create([
            'ou_id' => '2',
            'responsable_id' => '14104369',
            'service_request_id' => '1',
            'sign_position' => '3',
            'type' => 'visador',
            'employee' => 'Subdirector (S)',
            'status' => '1',
            'user_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

        SignatureFlow::create([
            'ou_id' => '59',
            'responsable_id' => '18263660',
            'service_request_id' => '1',
            'sign_position' => '4',
            'type' => 'visador',
            'employee' => 'Jefe (S)',
            'status' => '1',
            'user_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

        SignatureFlow::create([
            'ou_id' => '44',
            'responsable_id' => '15685508',
            'service_request_id' => '1',
            'sign_position' => '5',
            'type' => 'visador',
            'employee' => 'Subdirector (S)',
            'status' => '1',
            'user_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

        SignatureFlow::create([
            'ou_id' => '40',
            'responsable_id' => '17432199',
            'service_request_id' => '1',
            'sign_position' => '6',
            'type' => 'visador',
            'employee' => 'Jefe (S)',
            'status' => '1',
            'user_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);
    }
}
