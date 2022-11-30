<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Parameters\Profession;
use App\Models\Parameters\Estament;

class RemoveCategoryFromCfgEstamentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $professions = Profession::all();
        foreach($professions as $profession)
        {
            switch($profession->category)
            {
                case 'A':
                case 'B':
                    $profession->estament_id = 3; //Profesional
                    break;
                case 'C':
                case 'D':
                    $profession->estament_id = 4; // Técnico
                    break;
                case 'F':
                    $profession->estament_id = 2; // Auxiliar
                    break;
                case 'E':
                    $profession->estament_id = 1; // Administrativo
                    break;
            }
            $profession->save();
        }

        Schema::table('cfg_estaments', function (Blueprint $table) {
            $table->dropColumn('category');
        });

        $estament = Estament::find(1);
        $estament->name = 'Administrativo';
        $estament->save();

        $estament = Estament::find(2);
        $estament->name = 'Auxiliar';
        $estament->save();

        $estament = Estament::find(3);
        $estament->name = 'Profesional';
        $estament->save();

        $estament = Estament::find(4);
        $estament->name = 'Técnico';
        $estament->save();

        $estament = Estament::find(5);
        if($estament) $estament->delete();
        $estament = Estament::find(6);
        if($estament) $estament->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cfg_estaments', function (Blueprint $table) {
            $table->string('category',1);
        });
    }
}
