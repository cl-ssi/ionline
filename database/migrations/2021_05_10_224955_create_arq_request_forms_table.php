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
        Schema::create('arq_request_forms', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->nullable();
            $table->foreignId('purchase_plan_id')->nullable()->constrained('ppl_purchase_plans');
            $table->foreignId('request_form_id')->nullable()->constrained('arq_request_forms');
            $table->foreignId('request_user_id')->nullable()->constrained('users');
            $table->foreignId('request_user_ou_id')->nullable()->constrained('organizational_units'); //u.o. del responsable
            $table->foreignId('contract_manager_id')->nullable()->constrained('users');
            $table->foreignId('contract_manager_ou_id'); //u.o. del responsable
            $table->foreignId('establishment_id')->constrained('establishments');
            $table->longText('name');
            $table->float('estimated_expense', 15, 2);
            $table->boolean('has_increased_expense')->nullable();
            $table->string('type_of_currency');
            $table->tinyInteger('superior_chief')->nullable();
            $table->string('program')->nullable();
            $table->foreignId('program_id')->constrained('cfg_programs');
            $table->longText('justification');
            $table->string('type_form');
            $table->string('subtype')->nullable();
            $table->string('sigfe')->nullable();
            $table->string('bidding_number')->nullable(); //id nro. de licitación.
            $table->string('status');
            $table->foreignId('purchase_mechanism_id')->constrained('cfg_purchase_mechanisms');
            $table->foreignId('purchase_unit_id')->nullable()->constrained('cfg_purchase_units');
            $table->foreignId('purchase_type_id')->nullable()->constrained('cfg_purchase_types');
            $table->foreignId('signatures_file_id')->nullable()->constrained('doc_signatures_files');
            $table->foreignId('old_signatures_file_id')->nullable()->constrained('doc_signatures_files');
            $table->timestamp('approved_at')->nullable();

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
        Schema::dropIfExists('arq_request_forms');
    }
};
