<?php

use Illuminate\Database\Seeder;
use App\Parameters\Proffesional;

class ProffesionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Proffesional::create([  'name' => 'Médico',
                                'category' => 'A']);
        Proffesional::create([  'name' => 'Odontólogo',
                                'category' => 'A']);
        Proffesional::create([  'name' => 'Químico farmacéutico',
                                'category' => 'A']);
        Proffesional::create([  'name' => 'Enfermero/a',
                                'category' => 'Profesional']);
        Proffesional::create([  'name' => 'Matron/a',
                                'category' => 'Profesional']);
        Proffesional::create([  'name' => 'Psicólogo/a',
                                'category' => 'Profesional']);
        Proffesional::create([  'name' => 'Kinesiólogo/a',
                                'category' => 'Profesional']);
        Proffesional::create([  'name' => 'Nutricionista',
                                'category' => 'Profesional']);
        Proffesional::create([  'name' => 'Trabajador/a Social',
                                'category' => 'Profesional']);
        Proffesional::create([  'name' => 'Terapeuta Ocupacional',
                                'category' => 'Profesional']);
        Proffesional::create([  'name' => 'Fonoaudiólogo/a',
                                'category' => 'Profesional']);
        Proffesional::create([  'name' => 'Prevencionista de Riesgo',
                                'category' => 'Profesional']);
        Proffesional::create([  'name' => 'Tecnólogo/a Médico Laboratorio',
                                'category' => 'Profesional']);
        Proffesional::create([  'name' => 'Tecnólogo/a Médico Imagenología',
                                'category' => 'Profesional']);
        Proffesional::create([  'name' => 'Bioquímico/a',
                                'category' => 'Profesional']);
        Proffesional::create([  'name' => 'Biotecnólogo/a',
                                'category' => 'Profesional']);
        Proffesional::create([  'name' => 'Ingeniero/a Biomédico',
                                'category' => 'Profesional']);
        Proffesional::create([  'name' => 'Ingeniero/a Informático',
                                'category' => 'Profesional']);
        Proffesional::create([  'name' => 'Ingeniero/a Comercial',
                                'category' => 'Profesional']);
        Proffesional::create([  'name' => 'Ingeniero/a Industrial',
                                'category' => 'Profesional']);
        Proffesional::create([  'name' => 'Ingeniero/a',
                                'category' => 'Profesional']);
        Proffesional::create([  'name' => 'Técnico Nivel Superior Enfermería',
                                'category' => 'Técnico']);
        Proffesional::create([  'name' => 'Técnico Nivel Superior Odontología',
                                'category' => 'Técnico']);
        Proffesional::create([  'name' => 'Técnico Nivel Superior',
                                'category' => 'Técnico']);
        Proffesional::create([  'name' => 'Técnico Paramédico',
                                'category' => 'D']);
        Proffesional::create([  'name' => 'Administrativo/a',
                                'category' => 'E']);
        Proffesional::create([  'name' => 'Auxiliar de Servicio',
                                'category' => 'F']);
        Proffesional::create([  'name' => 'Chofer',
                                'category' => 'F']);
        Proffesional::create([  'name' => 'Otros Profesionales',
                                'category' => 'B']);
        Proffesional::create([  'name' => 'Otros Técnicos',
                                'category' => 'C']);
        Proffesional::create([  'name' => 'Constructor civil',
                                'category' => 'B']);
        Proffesional::create([  'name' => 'Arquitecto',
                                'category' => 'B']);
        Proffesional::create([  'name' => 'Dibujante técnico proyectista',
                                'category' => 'C']);
        Proffesional::create([  'name' => 'Abogado/a',
                                'category' => 'B']);
        Proffesional::create([  'name' => 'Técnico en rehabilitación',
                                'category' => 'C']);
        Proffesional::create([  'name' => 'Psiquiatra',
                                'category' => 'B']);
        Proffesional::create([  'name' => 'Monitor/a',
                                'category' => 'C']);
        Proffesional::create([  'name' => 'Preparador físico',
                                'category' => 'C']);
    }
}
