<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Documents\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([ 'name' => 'Memo']); /* DocDigital (Momorando)*/
        Type::create([ 'name' => 'Oficio']); /* DocDigital */
        Type::create([ 'name' => 'Carta']); /* DocDigital */
        Type::create([ 'name' => 'Circular']); /* DocDigital */
        Type::create([ 'name' => 'Resolución']); /* DocDigital (Resoluciones) */
        Type::create([ 'name' => 'Convenio', 'partes_exclusive' => true]); /* DocDigital (Convenios)*/
        
        Type::create([ 'name' => 'Ordinario']); /* De baja, reemplazado por Oficio */
        Type::create([ 'name' => 'Informe']);
        Type::create([ 'name' => 'Protocolo']);
        Type::create([ 'name' => 'Acta']);
        Type::create([ 'name' => 'Acta de recepción']);
        Type::create([ 'name' => 'Acta de recepción obras menores']);
        
        /** Sólo para oficina de partes */
        Type::create([ 'name' => 'Decreto', 'partes_exclusive' => true]);
        Type::create([ 'name' => 'Demanda', 'partes_exclusive' => true]);
        Type::create([ 'name' => 'Permiso Gremial', 'partes_exclusive' => true]);
        Type::create([ 'name' => 'Otro', 'partes_exclusive' => true]);
    }
}
