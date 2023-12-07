<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fin_receptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('number')->nullable(); // Correlatives
            $table->string('internal_number')->nullable(); // Correlatives
            $table->date('date');
            $table->foreignId('reception_type_id')->constrained('fin_reception_types');

            $table->string('purchase_order')->nullable();

            $table->foreignId('guia_id')->nullable()->constrained('fin_dtes');
            $table->foreignId('dte_id')->nullable()->constrained('fin_dtes');

            $table->string('dte_type')->nullable();
            $table->string('dte_number')->nullable();
            $table->date('dte_date')->nullable();

            $table->text('header_notes')->nullable();
            $table->text('footer_notes')->nullable();

            $table->boolean('rejected')->default(0);
            $table->text('rejected_notes')->nullable();

            $table->boolean('partial_reception')->nullable(); // Si se selecciono completa o parcial

            $table->unsignedInteger('neto')->nullable();
            $table->unsignedInteger('descuentos')->nullable();
            $table->unsignedInteger('cargos')->nullable();
            $table->unsignedInteger('subtotal')->nullable();
            $table->unsignedInteger('iva')->nullable();
            $table->unsignedInteger('total')->nullable();

            // $table->string('file')->nullable();

            $table->boolean('status')->nullable();

            $table->foreignId('responsable_id')->nullable()->constrained('users');
            $table->foreignId('responsable_ou_id')->nullable()->constrained('organizational_units');
            
            $table->foreignId('creator_id')->constrained('users');
            $table->foreignId('creator_ou_id')->constrained('organizational_units');

            $table->foreignId('establishment_id')->constrained('establishments');

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
        Schema::dropIfExists('fin_receptions');
    }
};
