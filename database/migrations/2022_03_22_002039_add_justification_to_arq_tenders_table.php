<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJustificationToArqTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_tenders', function (Blueprint $table) {
            $table->text('justification')->nullable()->after('duration');
            $table->dropColumn('type_of_purchase'); // no se ocupa está demás
            $table->string('resol_administrative_bases')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_tenders', function (Blueprint $table) {
            $table->string('resol_administrative_bases')->nullable(false)->change();
            $table->string('type_of_purchase')->nullable()->after('status');
            $table->dropColumn('justification');
        });
    }
}
