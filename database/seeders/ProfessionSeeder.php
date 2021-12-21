<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parameters\Profession;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Profession::create([  'name' => 'Médico',
                                'category' => 'A']);
        Profession::create([  'name' => 'Odontólogo',
                                'category' => 'A']);
        Profession::create([  'name' => 'Químico farmacéutico',
                                'category' => 'A']);
        Profession::create([  'name' => 'Enfermero/a',
                                'category' => 'Profesional']);
        Profession::create([  'name' => 'Matron/a',
                                'category' => 'Profesional']);
        Profession::create([  'name' => 'Psicólogo/a',
                                'category' => 'Profesional']);
        Profession::create([  'name' => 'Kinesiólogo/a',
                                'category' => 'Profesional']);
        Profession::create([  'name' => 'Nutricionista',
                                'category' => 'Profesional']);
        Profession::create([  'name' => 'Trabajador/a Social',
                                'category' => 'Profesional']);
        Profession::create([  'name' => 'Terapeuta Ocupacional',
                                'category' => 'Profesional']);
        Profession::create([  'name' => 'Fonoaudiólogo/a',
                                'category' => 'Profesional']);
        Profession::create([  'name' => 'Prevencionista de Riesgo',
                                'category' => 'Profesional']);
        Profession::create([  'name' => 'Tecnólogo/a Médico Laboratorio',
                                'category' => 'Profesional']);
        Profession::create([  'name' => 'Tecnólogo/a Médico Imagenología',
                                'category' => 'Profesional']);
        Profession::create([  'name' => 'Bioquímico/a',
                                'category' => 'Profesional']);
        Profession::create([  'name' => 'Biotecnólogo/a',
                                'category' => 'Profesional']);
        Profession::create([  'name' => 'Ingeniero/a Biomédico',
                                'category' => 'Profesional']);
        Profession::create([  'name' => 'Ingeniero/a Informático',
                                'category' => 'Profesional']);
        Profession::create([  'name' => 'Ingeniero/a Comercial',
                                'category' => 'Profesional']);
        Profession::create([  'name' => 'Ingeniero/a Industrial',
                                'category' => 'Profesional']);
        Profession::create([  'name' => 'Ingeniero/a',
                                'category' => 'Profesional']);
        Profession::create([  'name' => 'Técnico Nivel Superior Enfermería',
                                'category' => 'Técnico']);
        Profession::create([  'name' => 'Técnico Nivel Superior Odontología',
                                'category' => 'Técnico']);
        Profession::create([  'name' => 'Técnico Nivel Superior',
                                'category' => 'Técnico']);
        Profession::create([  'name' => 'Técnico Paramédico',
                                'category' => 'D']);
        Profession::create([  'name' => 'Administrativo/a',
                                'category' => 'E']);
        Profession::create([  'name' => 'Auxiliar de Servicio',
                                'category' => 'F']);
        Profession::create([  'name' => 'Chofer',
                                'category' => 'F']);
        Profession::create([  'name' => 'Otros Profesionales',
                                'category' => 'B']);
        Profession::create([  'name' => 'Otros Técnicos',
                                'category' => 'C']);
        Profession::create([  'name' => 'Constructor civil',
                                'category' => 'B']);
        Profession::create([  'name' => 'Arquitecto',
                                'category' => 'B']);
        Profession::create([  'name' => 'Dibujante técnico proyectista',
                                'category' => 'C']);
        Profession::create([  'name' => 'Abogado/a',
                                'category' => 'B']);
        Profession::create([  'name' => 'Técnico en rehabilitación',
                                'category' => 'C']);
        Profession::create([  'name' => 'Psiquiatra',
                                'category' => 'B']);
        Profession::create([  'name' => 'Monitor/a',
                                'category' => 'C']);
        Profession::create([  'name' => 'Preparador físico',
                                'category' => 'C']);
    }
}
