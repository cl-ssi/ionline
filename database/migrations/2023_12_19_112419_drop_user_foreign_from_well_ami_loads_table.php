<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('well_ami_loads', function (Blueprint $table) {
            $table->dropForeign(['run']);
            $table->unique(['id_amipass','sucursal','centro_de_costo','n_factura','fecha','n_tarjeta','run'],'UNIQUE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('well_ami_loads', function (Blueprint $table) {
            //
        });
    }
};
