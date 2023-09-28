<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Rrhh\Absenteeism;
use App\Models\Rrhh\AbsenteeismType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rrhh_absenteeisms', function (Blueprint $table) {
            $table->foreignId('absenteeism_type_id')->nullable()->after('tipo_de_ausentismo')->constrained('rrhh_absenteeism_types');
        });

        // asigna id de tipo de asentismo en tabla de ausentismos (solo si existe información)
        if(Absenteeism::count()>0){
            $absenteeisms = Absenteeism::all();
            foreach($absenteeisms as $absenteeism){
                if(AbsenteeismType::where('name',$absenteeism->tipo_de_ausentismo)->count()>0){
                    $absenteeism->absenteeism_type_id = AbsenteeismType::where('name',$absenteeism->tipo_de_ausentismo)->first()->id;
                    $absenteeism->save();
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rrhh_absenteeisms', function (Blueprint $table) {
            $table->dropForeign('rrhh_absenteeisms_absenteeism_type_id_foreign');
            $table->dropColumn('absenteeism_type_id');
        });
    }
};
