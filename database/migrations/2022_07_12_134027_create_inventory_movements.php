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
        Schema::create('inv_inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->boolean('reception_confirmation')->default(0)->nullable();
            $table->timestamp('reception_date')->nullable();
            $table->date('installation_date')->nullable();
            $table->text('observations')->nullable();
            $table->foreignId('inventory_id')->nullable()->constrained('inv_inventories');
            $table->foreignId('place_id')->nullable()->constrained('cfg_places');
            $table->foreignId('user_responsible_ou_id')->nullable()->constrained('organizational_units');
            $table->foreignId('user_responsible_id')->nullable()->constrained('users');
            $table->foreignId('user_using_ou_id')->nullable()->constrained('organizational_units');
            $table->foreignId('user_using_id')->nullable()->constrained('users');
            $table->foreignId('user_sender_id')->nullable()->constrained('users');

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
        Schema::dropIfExists('inv_inventory_movements');
    }
};
