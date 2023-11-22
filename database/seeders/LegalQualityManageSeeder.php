<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReplacementStaff\LegalQualityManage;

class LegalQualityManageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LegalQualityManage::Create(['name'  => 'to hire']);
        LegalQualityManage::Create(['name'  => 'fee']);
        LegalQualityManage::Create(['name'  => 'holder']);
    }
}
