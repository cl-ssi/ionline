<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlternativeToPsiOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('psi_options', function (Blueprint $table) {
            //
            $table->char('alternative',1)->after('option_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('psi_options', function (Blueprint $table) {
            //
            $table->dropColumn('alternative');
        });
    }
}
