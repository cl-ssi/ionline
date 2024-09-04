<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddActiveAgreementToCfgBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cfg_banks', function (Blueprint $table) {
            $table->boolean('active_agreement')->default(false)->after('code');
        });

        // Actualizar todos los registros existentes para que 'active_agreement' sea true
        DB::table('cfg_banks')->update(['active_agreement' => true]);

        // Insertar un nuevo banco llamado 'BANCO COOPEUCH' con 'active_agreement' en false
        DB::table('cfg_banks')->insert([
            'name' => 'BANCO COOPEUCH',
            'code' => '',
            'active_agreement' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cfg_banks', function (Blueprint $table) {
            $table->dropColumn('active_agreement');
        });
    }
}
