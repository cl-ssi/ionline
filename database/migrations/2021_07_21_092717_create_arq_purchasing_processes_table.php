<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArqPurchasingProcessesTable extends Migration
{
    /**
     * Tipos de Estados en el Proceso de Compra.
     * Status:
     * not_available:  no disponible por parte del oferente
     * timed_out: caducado, excedido tiempo transcurrido según ley
     * desert: no se encuentra en el mercado
     * partial: entrega Parcial
     * total: entrega total
     * in_progress: en progreso
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_purchasing_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_mechanism_id')->constrained('cfg_purchase_mechanisms');
            $table->foreignId('purchase_type_id')->constrained('cfg_purchase_types');
            $table->dateTime('start_date', $precision = 0);
            $table->dateTime('end_date', $precision = 0)->nullable();
            $table->string('status'); // 'in_progress', 'total', 'partial', 'desert',  'timed_out', 'not_available'
            $table->text('observation')->nullable();
            $table->foreignId('user_id')->constrained('users');; //Usuario que crea el proceso de compra.
            $table->foreignId('request_form_id')->constrained('arq_request_forms');

            // $table->foreignId('purchase_unit_id');
            // $table->foreignId('item_request_form_id');
            // $table->enum('status', ['in_progress', 'total', 'partial', 'desert',  'timed_out', 'not_available']);
            // $table->dateTime('status_change_date', $precision = 0)->nullable();
            // $table->string('id_oc')->nullable();
            // $table->string('id_internal_oc')->nullable();
            // $table->dateTime('date_oc', $precision = 0)->nullable();
            // $table->dateTime('shipping_date_oc', $precision = 0)->nullable();
            // $table->string('id_big_buy')->nullable();
            // $table->integer('peso_amount')->nullable();
            // $table->integer('dollar_amount')->nullable();
            // $table->integer('uf_amount')->nullable();
            // $table->integer('delivery_term')->nullable();
            // $table->dateTime('delivery_date', $precision = 0)->nullable();
            // $table->string('id_offer')->nullable();
            // $table->string('id_quotation')->nullable();

            // $table->foreign('purchase_mechanism_id')->references('id')->on('cfg_purchase_mechanisms');
            // $table->foreign('purchase_type_id')->references('id')->on('cfg_purchase_types');
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('purchase_unit_id')->references('id')->on('cfg_purchase_units');
            // $table->foreign('item_request_form_id')->references('id')->on('arq_item_request_forms');

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
        Schema::dropIfExists('arq_purchasing_processes');
    }
}
