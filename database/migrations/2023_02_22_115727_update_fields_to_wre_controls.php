<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFieldsToWreControls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wre_controls', function (Blueprint $table) {
            $table->renameColumn('guide_number', 'document_number');
            $table->renameColumn('guide_date', 'document_date');
            $table->string('document_type')
                ->after('po_date')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wre_controls', function (Blueprint $table) {
            //
        });
    }
}
