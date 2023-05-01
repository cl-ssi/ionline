<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnDeisToEstablishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $query = "UPDATE establishments set new_mother_code = null WHERE new_mother_code = 'No Aplica'";
        DB::statement($query);

        Schema::table('establishments', function (Blueprint $table) {
            $table->integer('new_mother_code')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('establishments', function (Blueprint $table) {
            $table->string('new_mother_code')->change();
        });
    }
}
