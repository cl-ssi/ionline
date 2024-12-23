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
        Schema::create('arq_tenders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_type_id')->default(13)->constrained('cfg_purchase_types');
            $table->string('currency')->nullable();
            $table->string('tender_number')->nullable();
            $table->string('description');
            $table->text('full_description')->nullable();
            $table->boolean('is_lower_amount')->nullable();
            $table->string('resol_administrative_bases')->nullable();
            $table->string('resol_adjudication')->nullable();
            $table->string('resol_deserted')->nullable();
            $table->string('resol_contract')->nullable();
            $table->string('guarantee_ticket')->nullable();
            $table->date('guarantee_ticket_exp_date')->nullable();
            $table->string('memo_number')->nullable();
            $table->boolean('has_taking_of_reason')->nullable();
            $table->date('taking_of_reason_date')->nullable();
            $table->string('status');
            // $table->string('type_of_purchase');

            $table->foreignId('supplier_id')->nullable()->constrained('cfg_suppliers');
            $table->dateTime('creation_date')->nullable();
            $table->dateTime('closing_date')->nullable();
            $table->dateTime('initial_date')->nullable();
            $table->dateTime('final_date')->nullable();
            $table->dateTime('pub_answers_date')->nullable();
            $table->dateTime('opening_act_date')->nullable();
            $table->dateTime('pub_date')->nullable();
            $table->dateTime('grant_date')->nullable();
            $table->dateTime('estimated_grant_date')->nullable();
            $table->dateTime('field_visit_date')->nullable();
            $table->integer('n_suppliers')->nullable();
            $table->date('start_date')->nullable();
            $table->integer('duration')->nullable();
            $table->text('justification')->nullable();

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
};
