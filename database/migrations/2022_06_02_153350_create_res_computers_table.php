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
        Schema::create('res_computers', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['desktop', 'all-in-one', 'notebook', 'other']);
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial')->nullable();
            $table->string('hostname')->nullable(); //new
            $table->string('domain')->nullable(); //new
            $table->ipAddress('ip')->nullable();
            $table->macAddress('mac_address')->nullable()->unique(); //new
            $table->string('ip_group')->nullable();
            $table->string('rack')->nullable();
            $table->string('vlan')->nullable();
            $table->string('network_segment')->nullable();

            $table->string('operating_system')->nullable(); //new
            $table->string('processor')->nullable(); //new
            $table->string('ram')->nullable(); //new
            $table->string('hard_disk')->nullable(); //new

            $table->integer('inventory_number')->nullable();
            $table->enum('active_type', ['leased', 'own', 'user']); //new
            $table->string('intesis_id')->nullable(); //new
            $table->string('comment')->nullable();

            $table->enum('status', ['active', 'inactive'])->nullable(); //new
            $table->string('office_serial')->nullable(); //new
            $table->string('windows_serial')->nullable(); //new
            $table->foreignId('place_id')->nullable()->constrained('cfg_places');
            $table->foreignId('inventory_id')->nullable()->constrained('inv_inventories');
            $table->timestamp('fusion_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('res_computer_user', function (Blueprint $table) {
            $table->foreignId('computer_id')->constrained('res_computers')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('res_computer_user');
        Schema::dropIfExists('res_computers');
    }
};
