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
        Schema::create('alw_allowances', function (Blueprint $table) {
            $table->id();
            $table->unsignedinteger('correlative')->nullable();
            $table->string('folio_sirh')->nullable()->unique();
            $table->string('status')->nullable();
            $table->foreignId('user_allowance_id')->constrained('users');
            $table->string('contractual_condition')->nullable();
            $table->foreignId('contractual_condition_id')->nullable()->constrained('cfg_contractual_conditions');
            $table->string('position')->nullable();
            $table->foreignId('allowance_value_id')->constrained('cfg_allowance_values');
            $table->string('grade')->nullable();
            $table->string('law')->nullable();
            $table->foreignId('establishment_id')->constrained('establishments');
            $table->foreignId('organizational_unit_allowance_id')->constrained('organizational_units');
            $table->string('place')->nullable();
            $table->string('reason')->nullable();
            $table->boolean('overnight')->nullable();
            $table->boolean('accommodation')->nullable();
            $table->boolean('food')->nullable();
            $table->boolean('passage')->nullable();
            $table->string('means_of_transport')->nullable();
            $table->foreignId('origin_commune_id')->constrained('cl_communes');
            $table->foreignId('destination_commune_id')->nullable()->constrained('cl_communes');
            $table->string('round_trip')->nullable();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->decimal('total_days', 5, 2);
            $table->decimal('total_half_days', 5, 2);
            $table->decimal('fifty_percent_total_days', 5, 2);
            $table->decimal('sixty_percent_total_days', 5, 2)->nullable();
            $table->boolean('half_days_only')->nullable();
            $table->integer('day_value')->nullable();
            $table->decimal('half_day_value', 10, 2);
            $table->decimal('fifty_percent_day_value', 10, 2);
            $table->decimal('sixty_percent_day_value', 10, 2)->nullable();
            $table->integer('total_value')->nullable();
            $table->foreignId('creator_user_id')->constrained('users');
            $table->foreignId('creator_ou_id')->constrained('organizational_units');
            $table->date('document_date')->nullable();
            $table->foreignId('signature_id')->nullable()->constrained('doc_signatures');

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
        Schema::dropIfExists('alw_allowances');
    }
};
