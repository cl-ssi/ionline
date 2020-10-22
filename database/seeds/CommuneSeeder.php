<?php

use Illuminate\Database\Seeder;
use App\Models\Commune;

class CommuneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* id = 1 */ Commune::Create(['name'=>'Colchane']);
        /* id = 2 */ Commune::Create(['name'=>'Huara']);
        /* id = 3 */ Commune::Create(['name'=>'Camiña']);
        /* id = 4 */ Commune::Create(['name'=>'Pozo Almonte']);
        /* id = 5 */ Commune::Create(['name'=>'Pica']);
        /* id = 6 */ Commune::Create(['name'=>'Iquique']);
        /* id = 7 */ Commune::Create(['name'=>'Alto Hospicio']);

    }
}
