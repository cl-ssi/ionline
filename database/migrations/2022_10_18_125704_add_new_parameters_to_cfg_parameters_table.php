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
            'module'      => 'nav',
            'parameter'   => 'accessRF',
            'value'       => 38,
            'description' => 'Acceso en el nav a modulo formularios de requerimiento en base a Ids de establecimientos separados por coma']);

        Parameter::Create([
            'module'      => 'ou',
            'parameter'   => 'AbastecimientoSSI',
            'value'       => 37,
            'description' => 'Departamento de Gestión de Abastecimiento y Logística del Servicio Salud Tarapacá']);

        Parameter::Create([
            'module'      => 'ou',
            'parameter'   => 'FinanzasSSI',
            'value'       => 40,
            'description' => 'Departamento de Gestión Financiera del Servicio Salud Tarapacá']);
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
