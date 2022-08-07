<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsApiToArqTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_tenders', function (Blueprint $table) {
            $table->text('full_description')->nullable()->after('description'); // Descripcion
            $table->string('currency')->nullable()->after('purchase_type_id'); // Moneda
            $table->dateTime('creation_date')->nullable()->after('supplier_id');  // FechaCreacion
            $table->dateTime('closing_date')->nullable()->after('creation_date'); // FechaCierre
            $table->dateTime('initial_date')->nullable()->after('closing_date'); // FechaInicio
            $table->dateTime('final_date')->nullable()->after('initial_date'); // FechaFinal
            $table->dateTime('pub_answers_date')->nullable()->after('final_date'); // FechaPubRespuestas
            $table->dateTime('opening_act_date')->nullable()->after('pub_answers_date'); // FechaActoAperturaTecnica
            $table->dateTime('pub_date')->nullable()->after('opening_act_date'); // FechaPublicacion
            $table->dateTime('grant_date')->nullable()->after('pub_date'); // FechaAdjudicacion
            $table->dateTime('estimated_grant_date')->nullable()->after('grant_date'); // FechaEstimadaAdjudicacione
            $table->dateTime('field_visit_date')->nullable()->after('estimated_grant_date'); // FechaVisitaTerreno
            $table->integer('n_suppliers')->nullable()->after('field_visit_date'); // NumeroOferentes
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_tenders', function (Blueprint $table) {
            $table->dropColumn(['full_description', 'currency', 'creation_date', 'closing_date', 'initial_date', 'final_date', 'pub_answers_date', 'opening_act_date', 
                                'pub_date', 'grant_date', 'estimated_grant_date', 'field_visit_date', 'n_suppliers']);
        });
    }
}
