<?php

namespace Database\Seeders;

use App\Models\Finance\PurchaseOrder\Prefix;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrefixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1    Servicio de Salud Tarapacá  1637-
        // 2    Activo fijo                 1057838-
        // 3    Administracion de fondos    1077499-
        // 4    Bienes y servicios          1057448-
        // 5    Compra conjunta             1058517-
        // 6    Convenios GORE              1180968-
        // 7    Fármacos                    1058052-
        // 8    Hospital Alto Hospicio      1272565-
        // 9    Hospital Dr. Hector Reyno   5483-
        // 10   Obras civiles               1057964-
        // 11   Servicio de Bienestar       2549-
        // 12   Cenabat                     621-

        Prefix::create([
            'name' => 'Servicio de Salud Tarapacá',
            'prefix' => '1637',
            'establishment_id' => 38,
        ]);

        Prefix::create([
            'name' => 'Activo fijo',
            'prefix' => '1057838',
            'establishment_id' => 38,
        ]);

        Prefix::create([
            'name' => 'Administracion de fondos',
            'prefix' => '1077499',
            'establishment_id' => 38,
        ]);

        Prefix::create([
            'name' => 'Bienes y servicios',
            'prefix' => '1057448',
            'establishment_id' => 38,
        ]);

        Prefix::create([
            'name' => 'Compra conjunta',
            'prefix' => '1058517',
            'establishment_id' => 38,
        ]);

        Prefix::create([
            'name' => 'Convenios GORE',
            'prefix' => '1180968',
            'establishment_id' => 38,
        ]);

        Prefix::create([
            'name' => 'Fármacos',
            'prefix' => '1058052',
            'establishment_id' => 38,
        ]);

        Prefix::create([
            'name' => 'Hospital Alto Hospicio',
            'prefix' => '1272565',
            'establishment_id' => 41,
        ]);

        // Prefix::create([
        //     'name' => 'Hospital Dr. Hector Reyno',
        //     'prefix' => '5483',
        //     'establishment_id' => 1,
        // ]);

        Prefix::create([
            'name' => 'Obras civiles',
            'prefix' => '1057964',
            'establishment_id' => 38,
        ]);

        Prefix::create([
            'name' => 'Servicio de Bienestar',
            'prefix' => '2549',
            'establishment_id' => 38,
        ]);

        Prefix::create([
            'name' => 'Cenabast',
            'prefix' => '621',
            'cenabast' => true,
        ]);

        Prefix::create([
            'name' => 'Hospital Alto Hospicio',
            'prefix' => '1350296',
            'establishment_id' => 41,
        ]);

    }
}
