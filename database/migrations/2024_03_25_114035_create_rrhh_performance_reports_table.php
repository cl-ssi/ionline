<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rrhh_performance_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->nullable()->constrained('rrhh_performance_report_periods');
            $table->text('cantidad_de_trabajo')->nullable();
            $table->text('calidad_del_trabajo')->nullable();
            $table->text('conocimiento_del_trabajo')->nullable();
            $table->text('interes_por_el_trabajo')->nullable();
            $table->text('capacidad_trabajo_en_grupo')->nullable();
            $table->text('asistencia')->nullable();
            $table->text('puntualidad')->nullable();
            $table->text('cumplimiento_normas_e_instrucciones')->nullable();
            $table->text('creator_user_observation')->nullable();
            $table->text('received_user_observation')->nullable();
            $table->foreignId('created_user_id')->nullable()->constrained('users');
            $table->foreignId('created_ou_id')->nullable()->constrained('organizational_units');
            $table->foreignId('received_user_id')->nullable()->constrained('users');
            $table->foreignId('received_ou_id')->nullable()->constrained('organizational_units');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rrhh_performance_reports');
    }
};
