<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      //assignation simulator
        Schema::create('as_assignments', function (Blueprint $table) {
            $table->id();
            $table->string('process')->nullable();
            $table->string('invoice')->nullable();
            $table->integer('payment_year')->nullable();
            $table->integer('payment_month')->nullable();
            $table->integer('accrual_year')->nullable();
            $table->integer('accrual_month')->nullable();
            $table->string('rut')->nullable();
            $table->integer('correlative')->nullable();
            $table->integer('payment_correlative')->nullable();
            $table->string('name')->nullable();
            $table->integer('establishment')->nullable();
            $table->string('legal_quality')->nullable();
            $table->integer('hours')->nullable();
            $table->integer('bienio')->nullable();
            $table->string('service')->nullable();
            $table->string('unity')->nullable();

            $table->string('porc_est_jorn_prior')->nullable();
            $table->string('porc_est_compet_prof')->nullable();
            $table->string('porc_est_cond_especial')->nullable();
            $table->string('porc_est_riesgo')->nullable();
            $table->string('porc_est_lugar_aislado')->nullable();
            $table->string('porc_est_turno_llamada')->nullable();
            $table->string('porc_est_resid_hosp')->nullable();
            $table->string('porc_prof_espe_art_16')->nullable();

            $table->decimal('assets_total',16,4)->nullable()->default('0');
            $table->decimal('base_salary',16,4)->nullable()->default('0');
            $table->decimal('antiquity',16,4)->nullable()->default('0');
            $table->decimal('experience',16,4)->nullable()->default('0');
            $table->decimal('responsibility',16,4)->nullable()->default('0');

            $table->decimal('est_jorn_prior',16,4)->nullable()->default('0');
            $table->decimal('est_compet_prof',16,4)->nullable()->default('0');
            $table->decimal('est_condic_lugar',16,4)->nullable()->default('0');
            $table->decimal('zone_asignation',16,4)->nullable()->default('0');
            $table->decimal('est_cond_especial',16,4)->nullable()->default('0');
            $table->decimal('est_resid_hosp',16,4)->nullable()->default('0');
            $table->decimal('est_prog_especiali',16,4)->nullable()->default('0');
            $table->decimal('est_riesgo',16,4)->nullable()->default('0');
            $table->decimal('est_lugar_aislado',16,4)->nullable()->default('0');
            $table->decimal('asig_permanencia',16,4)->nullable()->default('0');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('as_assignments');
    }
}
