<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReplacementStaff\FundamentDetailManage;

class RstFundamentDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FundamentDetailManage::Create(['name'=>'quit']);
        FundamentDetailManage::Create(['name'=>'allowance without payment']);
        FundamentDetailManage::Create(['name'=>'vacations']);
        FundamentDetailManage::Create(['name'=>'medical license']);
        FundamentDetailManage::Create(['name'=>'replacement previous announcement']);
        FundamentDetailManage::Create(['name'=>'internal announcement']);
        FundamentDetailManage::Create(['name'=>'mixed announcement']);
        FundamentDetailManage::Create(['name'=>'other']);
    }
}
