<?php

use Illuminate\Database\Seeder;
use App\Resources\Wingle;

class WingleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wingle = new Wingle();
        $wingle->brand = 'Huawei';
        $wingle->model = 'E8372';
        $wingle->company = 'Entel';
        $wingle->imei = '864070030422149';
        $wingle->password = 'ssiqq02';
        $wingle->save();
    }
}
