<?php

use App\Models\Parameters\Parameter;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Parameter::Create([
            'module'      => 'ou',
            'parameter'   => 'DireccionSSI',
            'value'       => 1,
            'description' => 'Dirección del Servicio Salud Tarapacá']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
