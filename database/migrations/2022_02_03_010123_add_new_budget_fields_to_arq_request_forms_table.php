<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewBudgetFieldsToArqRequestFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arq_request_forms', function (Blueprint $table) {
            $table->string('folio')->nullable()->after('id'); // YYYY-CFR-CFRh-M => CFR: correlativo FR según año YYYY, CFRh: correlativo para FR hijos (opcional), M:  indicación de nuevo presupuesto al FR padre (opcional)
            // $table->integer('year')->nullable()->after('id');
            // $table->integer('number')->nullable()->after('year');
            $table->boolean('has_increased_expense')->nullable()->after('estimated_expense'); // M
            $table->foreignId('old_signatures_file_id')->nullable()->after('signatures_file_id')->constrained('doc_signatures_files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arq_request_forms', function (Blueprint $table) {
            $table->dropForeign(['old_signatures_file_id']);
            $table->dropColumn(['folio', 'has_increased_expense', 'old_signatures_file_id']);
        });
    }
}
