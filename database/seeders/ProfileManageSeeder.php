<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReplacementStaff\ProfileManage;


class ProfileManageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProfileManage::Create(['name'=>'Administrativo']);
        ProfileManage::Create(['name'=>'Auxiliar']);
        ProfileManage::Create(['name'=>'Profesional']);
        ProfileManage::Create(['name'=>'Técnico']);
    }
}
