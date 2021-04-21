<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeRecipitentsToDocSignatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doc_signatures', function (Blueprint $table) {
            $table->text('recipients')->nullable()->change();
            $table->text('distribution')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doc_signatures', function (Blueprint $table) {
            $table->string('recipients')->nullable()->change();
            $table->string('distribution')->nullable()->change();
        });
    }
}
