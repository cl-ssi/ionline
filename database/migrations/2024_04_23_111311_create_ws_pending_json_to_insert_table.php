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
        Schema::create('ws_pending_json_to_insert', function (Blueprint $table) {
            $table->id();
            $table->string('model_route');
            $table->longText('data_json');
            $table->text('column_mapping');
            $table->text('primary_keys');
            $table->boolean('procesed')->default(0);
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
        Schema::dropIfExists('ws_pending_json_to_insert');
    }
};
