<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rem\RemSerie;

class RemSerieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $remserie = new RemSerie();
        $remserie->name ='A';
        $remserie->name ='BM';
        $remserie->name ='BS';
        $remserie->name ='D';
    }
}
