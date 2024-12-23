<?php

use App\Models\Warehouse\TypeDispatch;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
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
            'name'   => 'Egreso Externo',
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
};
