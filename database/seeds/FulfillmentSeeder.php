<?php

use Illuminate\Database\Seeder;
use App\Models\ServiceRequest\Fulfillment;
use Carbon\Carbon;

class FulfillmentSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    
    public function run()
    {

        Fulfillment::create([
            'service_request_id' => '1',
            'year' => '2021',
            'month' => '10',
            'type' => 'Mensual',
            'start_date' => '2021-10-29 00:00:00',
            'end_date' => '2021-10-31 00:00:00',
            'user_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

        Fulfillment::create([
            'service_request_id' => '1',
            'year' => '2021',
            'month' => '11',
            'type' => 'Mensual',
            'start_date' => '2021-11-01 00:00:00',
            'end_date' => '2021-11-30 00:00:00',
            'user_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);

        Fulfillment::create([
            'service_request_id' => '1',
            'year' => '2021',
            'month' => '12',
            'type' => 'Parcial',
            'start_date' => '2021-12-01 00:00:00',
            'end_date' => '2021-12-01 00:00:00',
            'user_id' => '15287582',
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);
        
    }
}
