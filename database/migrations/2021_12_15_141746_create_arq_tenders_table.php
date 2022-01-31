<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArqTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arq_tenders', function (Blueprint $table) {
            $table->id();
            $table->string('tender_type');
            $table->string('tender_number')->nullable();
            $table->string('description');
            $table->string('resol_administrative_bases');
            $table->string('resol_adjudication')->nullable();
            $table->string('resol_deserted')->nullable();
            $table->string('resol_contract')->nullable();
            $table->string('guarantee_ticket')->nullable();
            $table->boolean('has_taking_of_reason')->nullable();
            $table->string('status');
            // $table->string('type_of_purchase');

            $table->foreignId('supplier_id')->nullable()->constrained('cfg_suppliers');

            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arq_tenders');
    }
}
