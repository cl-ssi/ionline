<?php

use App\Models\Warehouse\TypeDispatch;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToWreTypeDispatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $typeDispatch = TypeDispatch::find(1);
        $typeDispatch->update([
            'name' => 'Egreso Interno',
        ]);

        TypeDispatch::create([
            'name' => 'Egreso Externo',
            'active' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
