<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipToWreControls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wre_controls', function (Blueprint $table) {
            $table->foreignId('technical_signature_id')
                ->after('signer_id')
                ->nullable()
                ->constrained('doc_signatures');

            $table->foreignId('reception_signature_id')
                ->after('technical_signature_id')
                ->nullable()
                ->constrained('doc_signatures');
        });
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
