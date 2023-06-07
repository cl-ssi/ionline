<?php

use App\Models\Parameters\Parameter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParameterToCfgParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Parameter::Create([
            'module'     => 'ou',
            'parameter'  => 'DireccionSSI',
            'value'      => 1,
            'description'=> 'Dirección del Servicio Salud Tarapacá']);
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
}
