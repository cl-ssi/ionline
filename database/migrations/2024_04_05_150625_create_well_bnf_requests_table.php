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
        Schema::create('well_bnf_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subsidy_id')->constrained('well_bnf_subsidies');
            $table->foreignId('applicant_id')->constrained('users');
            $table->float('requested_amount', 14, 2)->nullable();
            $table->text('status'); //en revisión, aceptado, rechazado

            $table->integer('installments_number')->nullable();
            $table->integer('folio_number')->nullable();

            $table->datetime('status_update_date')->nullable();
            $table->foreignId('status_update_responsable_id')->nullable()->constrained('users');
            $table->text('status_update_observation')->nullable();

            $table->datetime('accepted_amount_date')->nullable();
            $table->foreignId('accepted_amount_responsable_id', 14, 2)->nullable()->constrained('users');
            $table->float('accepted_amount', 14, 2)->nullable();

            $table->datetime('payed_date')->nullable();
            $table->foreignId('payed_responsable_id')->nullable()->constrained('users');
            $table->float('payed_amount', 14, 2)->nullable();

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
        Schema::dropIfExists('well_bnf_requests');
    }
};
