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
        Type::create([ 'name' => 'Memo', 'doc_digital' => true]); /* DocDigital (Momorando)*/
        Type::create([ 'name' => 'Oficio', 'doc_digital' => true]); /* DocDigital */
        Type::create([ 'name' => 'Carta', 'doc_digital' => true]); /* DocDigital */
        Type::create([ 'name' => 'Circular', 'doc_digital' => true]); /* DocDigital */
        Type::create([ 'name' => 'Resolución', 'doc_digital' => true]); /* DocDigital (Resoluciones) */
        Type::create([ 'name' => 'Convenio', 'doc_digital' => true, 'partes_exclusive' => true]); /* DocDigital (Convenios)*/
        
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
