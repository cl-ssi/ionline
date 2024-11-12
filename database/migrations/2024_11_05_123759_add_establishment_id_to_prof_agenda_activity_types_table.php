<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddEstablishmentIdToProfAgendaActivityTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prof_agenda_activity_types', function (Blueprint $table) {
            $table->unsignedBigInteger('establishment_id')->nullable()->after('auto_reservable');
            
            // Definir la relación con la tabla de establishments (si aplica)
            $table->foreign('establishment_id')->references('id')->on('establishments')->onDelete('cascade');
        });

        // Asignar establishment_id = 38 a los registros existentes
        DB::table('prof_agenda_activity_types')->update(['establishment_id' => 38]);

        // Clonar registros y asignar establishment_id = 41 a los duplicados
        $records = DB::table('prof_agenda_activity_types')->get();
        foreach ($records as $record) {
            $newRecord = (array) $record; // Convertir el objeto a un array
            unset($newRecord['id']); // Eliminar el ID para la inserción
            $newRecord['establishment_id'] = 41; // Asignar nuevo establecimiento

            DB::table('prof_agenda_activity_types')->insert($newRecord);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Eliminar los registros con establishment_id = 41
        DB::table('prof_agenda_activity_types')->where('establishment_id', 41)->delete();

        // Eliminar la columna y la clave foránea
        Schema::table('prof_agenda_activity_types', function (Blueprint $table) {
            $table->dropForeign(['establishment_id']);
            $table->dropColumn('establishment_id');
        });
    }
}
