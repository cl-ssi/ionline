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
        Schema::create('res_computer_label', function (Blueprint $table) {
            $table->id();
            $table->foreignId('computer_id')->nullable()->constrained('res_computers');
            $table->foreignId('label_id')->nullable()->constrained('inv_labels');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('res_computer_label');
    }
};
