<?php

namespace Database\Seeders;

use App\Models\Parameters\Parameter;
use Illuminate\Database\Seeder;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parameter = Parameter::Create([
            'establishment_id'=>38,
            'module'=>'drugs',
            'parameter'=>'Jefe',
            'value'=>8908877,
            'description'=>'RUN (sin digito verificador) del encargado de la Unidad de Drogas',
            'establishment_id' => 38]);

        $parameter = Parameter::Create([
            'establishment_id'=>38,
            'module'=>'drugs',
            'parameter'=>'CargoJefe',
            'value'=>'Jefe Unidad de Drogas',
            'description'=>'Cargo del encargado de la Unidad de Drogas',
            'establishment_id' => 38]);

        $parameter = Parameter::Create([
            'establishment_id'=>38,
            'module'=>'drugs',
            'parameter'=>'Mandatado',
            'value'=>6811637,
            'description'=>'RUN (sin digito verificador) del mandatado',
            'establishment_id' => 38]);

        $parameter = Parameter::Create([
            'establishment_id'=>38,
            'module'=>'drugs',
            'parameter'=>'MandatadoResolucion',
            'value'=>'resolución exenta Nº 903, de 06 de Junio de 2014',
            'description'=>'Resolución y su fecha',
            'establishment_id' => 38]);

        $parameter = Parameter::Create([
            'establishment_id'=>38,
            'module'=>'drugs',
            'parameter'=>'MinistroDeFe',
            'value'=>17095355,
            'description'=>'Run (sin digito verificador) del ministro de Fe']);

        $parameter = Parameter::Create([
            'establishment_id'=>38,
            'module'=>'drugs',
            'parameter'=>'MinistroDeFeJuridico',
            'value'=>10147961,
            'description'=>'Run (sin digito verificador) del ministro de Fe',
            'establishment_id' => 38]);

        $parameter = Parameter::Create([
            'establishment_id'=>38,
            'module'=>'Agenda UST',
            'parameter'=>'profesiones_ust',
            'value'=>'1,4,5,6',
            'description'=>'Profesiones del módulo de Agendamiento UST',
            'establishment_id' => 38]);
    }
}
