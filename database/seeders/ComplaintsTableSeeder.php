<?php

namespace Database\Seeders;
use App\Models\Integrity\Complaint;
use App\Models\Integrity\ComplaintValue;
use App\Models\Integrity\ComplaintPrinciple;

use Illuminate\Database\Seeder;

class ComplaintsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $value = ComplaintValue::Create(['name'=>'Eficiencia']);
        $value = ComplaintValue::Create(['name'=>'Respeto']);
        $value = ComplaintValue::Create(['name'=>'Compromiso']);
        $value = ComplaintValue::Create(['name'=>'Transparencia']);
        $value = ComplaintValue::Create(['name'=>'Probidad']);
        $value = ComplaintValue::Create(['name'=>'Profesionalismo']);
        $value = ComplaintValue::Create(['name'=>'Excelencia']);
        $value = ComplaintValue::Create(['name'=>'Otro']);

        $principle = ComplaintPrinciple::Create(['name'=>'Probidad']);
        $principle = ComplaintPrinciple::Create(['name'=>'Legalidad']);
        $principle = ComplaintPrinciple::Create(['name'=>'Imparcialidad y objetividad']);
        $principle = ComplaintPrinciple::Create(['name'=>'Responsabilidad']);
        $principle = ComplaintPrinciple::Create(['name'=>'Mérito']);
        $principle = ComplaintPrinciple::Create(['name'=>'Integridad']);
        $principle = ComplaintPrinciple::Create(['name'=>'Eficiencia y eficacia']);
        $principle = ComplaintPrinciple::Create(['name'=>'Respeto']);
        $principle = ComplaintPrinciple::Create(['name'=>'Buen trato a los usuarios']);
        $principle = ComplaintPrinciple::Create(['name'=>'Coordinación y colaboración']);
        $principle = ComplaintPrinciple::Create(['name'=>'No sabe']);

        $c = new Complaint();
        $c->type='Consulta';
        $c->complaint_values_id =1;
        $c->complaint_principles_id =1;
        $c->content = 'Contenido de la consulta';
        $c->email = 'a@b.c';
        $c->know_code = true;
        $c->identify = true;
        $c->save();

        /*
        $complaint = Complaint::Create(['type'=>'Consulta', 'content'=>'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'email'=>'adfa@dsafas.com', 'know_code' => true, 'identify'=>false, 'complaint_values_id'=> 1, 'complaint_principles_id' => 2, 'user_id'=>15287582 ]);

        $complaint = Complaint::Create(['type'=>'Denuncia', 'content'=>'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'email'=>'alvaro@dsafas.com', 'know_code' => false, 'identify'=>true, 'complaint_values_id'=> 3, 'complaint_principles_id' => 5, 'user_id'=>15287582]);

        $complaint = Complaint::Create(['type'=>'Riesgo ético', 'content'=> 'Contenido riesgo ético', 'email'=>'torres@dsafas.com', 'know_code' => true, 'identify'=>true, 'complaint_values_id'=> 2, 'complaint_principles_id' => 7, 'user_id'=>16966444]);
        */
    }
}
