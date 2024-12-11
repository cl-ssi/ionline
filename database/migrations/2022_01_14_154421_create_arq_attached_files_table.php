<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_attached_files', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->string('document_type')->nullable();
            $table->foreignId('tender_id')->nullable()->constrained('arq_tenders');
            $table->foreignId('immediate_purchase_id')->nullable()->constrained('arq_immediate_purchases');
            $table->foreignId('direct_deal_id')->nullable()->constrained('arq_direct_deals');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arq_attached_files');
    }
};
