<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $establishmentTypes = [
            'CECOSF', 'CESFAM', 'CGR', 'COSAM', 'HOSPITAL', 'PRAIS', 'PSR', 'SAPU',
        ];
        foreach ($establishmentTypes as $type) {
            DB::statement("UPDATE establishments SET establishment_type_id = (SELECT id FROM establishment_types WHERE name like '%$type%' AND type like '%$type%') WHERE type like '%$type%'");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::statement('UPDATE establishments SET establishment_type_id = NULL');
    }
};
