<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReplacementStaff\RstFundamentManage;

class RstFundamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RstFundamentManage::Create(['name'=>'replacement']);
        RstFundamentManage::Create(['name'=>'quit']);
        RstFundamentManage::Create(['name'=>'expand work position']);
        RstFundamentManage::Create(['name'=>'other']);
        RstFundamentManage::Create(['name'=>'retirement']);
    }
}
