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
    public function insert_seed($mo,$ty,$sd,$ed,$id)
    {
        $SRID_Select = DB::table('doc_service_requests')->pluck('id');
        $UID_Select = DB::table('users')->pluck('id');

        Fulfillment::create([
            'service_request_id' => $SRID_Select[ $SRID_Select->search(1) ],
            'year' => '2021',
            'month' => $mo,
            'type' => $ty,
            'start_date' => $sd.' 00:00:00',
            'end_date' => $ed.' 00:00:00',
            'user_id' => $UID_Select[ $UID_Select->search($id) ],
            'created_at' => carbon::now(),
            'updated_at' => carbon::now()
        ]);
    }
    
    public function run()
    {
        FulfillmentSeeder::insert_seed('10','Mensual','2021-10-29','2021-10-31',15287582);
        FulfillmentSeeder::insert_seed('11','Mensual','2021-11-01','2021-11-30',15287582);
        FulfillmentSeeder::insert_seed('12','Parcial','2021-12-01','2021-12-01',15287582);
    }
}
