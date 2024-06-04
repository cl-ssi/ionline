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
        Schema::create('doc_organizational_unit_limits', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('establishment_id')->constrained('establishments');
            $table->foreignId('organizational_unit_id')->constrained('organizational_units');
            $table->integer('max_value');
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
        Schema::dropIfExists('doc_organizational_unit_limits');
    }
};
