<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfd_request_services', function (Blueprint $table) {
            $table->id();
            $table->string('article', 100);
            $table->enum('unit_of_measurement', ['Metro', 'Kilogramo', 'Libra', 'Litro', 'Metro Cúbico', 'Unidad']);
            $table->longText('technical_specifications');
            $table->float('quantity', 10, 3);
            $table->float('unit_value', 10, 3);
            $table->enum('taxes', ['iva', 'boleta de honorarios', 'srf', 'excento', 'no definido']);
            $table->float('total_value', 10, 3);
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
        Schema::dropIfExists('rfd_request_services');
    }
}
