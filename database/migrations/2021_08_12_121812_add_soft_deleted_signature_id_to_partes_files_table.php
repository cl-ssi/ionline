<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletedSignatureIdToPartesFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parte_files', function (Blueprint $table) {
            //
            $table->softDeletes()->after('updated_at')->nullable();;
            $table->foreignId('signature_file_id')->nullable()->after('parte_id');
            $table->foreign('signature_file_id')->references('id')->on('doc_signatures_files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parte_files', function (Blueprint $table) {
            //
            $table->dropColumn('deleted_at');
            $table->dropForeign(['signature_file_id']);
            $table->dropColumn('signature_file_id');

        });
    }    
    


}
