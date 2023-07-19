<?php

namespace Database\Seeders;

use App\Models\Summary\Actor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SumActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Actor::create([
            'name' => 'Autoridad',
        ]);

        Actor::create([
            'name' => 'Investigador',
        ]);

        Actor::create([
            'name' => 'Jurídica',
        ]);

        Actor::create([
            'name' => 'Secretario',
        ]);

        Actor::create([
            'name' => 'Denunciante',
        ]);

        Actor::create([
            'name' => 'Imputado',
        ]);
    }
}
