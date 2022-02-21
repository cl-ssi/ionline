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
        Profession::create(['name' => 'Médico','category' => 'A','estamento' => 'Profesional Médico']);
        Profession::create(['name' => 'Odontólogo','category' => 'A','estamento' => 'Profesional Médico']);
        Profession::create(['name' => 'Químico farmacéutico','category' => 'A','estamento' => 'Profesional Médico']);
        Profession::create(['name' => 'Enfermero/a','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Matron/a','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Psicólogo/a','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Kinesiólogo/a','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Nutricionista','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Trabajador/a Social','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Terapeuta Ocupacional','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Fonoaudiólogo/a','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Prevencionista de Riesgo','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Tecnólogo/a Médico Laboratorio','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Tecnólogo/a Médico Imagenología','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Bioquímico/a','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Biotecnólogo/a','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Ingeniero/a Biomédico','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Ingeniero/a Informático','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Ingeniero/a Comercial','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Ingeniero/a Industrial','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Ingeniero/a','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Otros Profesionales','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Constructor civil','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Arquitecto','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Abogado/a','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Psiquiatra','category' => 'B','estamento' => 'Profesional']);
        Profession::create(['name' => 'Técnico Nivel Superior Enfermería','category' => 'C','estamento' => 'Técnico']);
        Profession::create(['name' => 'Técnico Nivel Superior Odontología','category' => 'C','estamento' => 'Técnico']);
        Profession::create(['name' => 'Técnico Nivel Superior','category' => 'C','estamento' => 'Técnico']);
        Profession::create(['name' => 'Otros Técnicos','category' => 'C','estamento' => 'Técnico']);
        Profession::create(['name' => 'Dibujante técnico proyectista','category' => 'C','estamento' => 'Técnico']);
        Profession::create(['name' => 'Técnico en rehabilitación','category' => 'C','estamento' => 'Técnico']);
        Profession::create(['name' => 'Monitor/a','category' => 'C','estamento' => 'Técnico']);
        Profession::create(['name' => 'Preparador físico','category' => 'C','estamento' => 'Técnico']);
        Profession::create(['name' => 'Técnico Paramédico','category' => 'D','estamento' => 'Técnico']);
        Profession::create(['name' => 'Administrativo/a','category' => 'E','estamento' => 'Administrativo']);
        Profession::create(['name' => 'Auxiliar de Servicio','category' => 'F','estamento' => 'Auxiliar']);
        Profession::create(['name' => 'Chofer','category' => 'F','estamento' => 'Auxiliar']);
    }
}
