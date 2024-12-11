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
        Schema::create('drg_sample_to_isps', function (Blueprint $table) {
            $table->id('id');
            $table->integer('number')->nullable();
            $table->date('document_date')->nullable();
            $table->decimal('envelope_weight', 8, 2);
            $table->text('observation')->nullable();
            $table->foreignId('reception_id')->constrained('drg_receptions');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('manager_id')->constrained('users');
            $table->foreignId('lawyer_id')->constrained('users');
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
        Schema::dropIfExists('drg_sample_to_isps');
    }
};
