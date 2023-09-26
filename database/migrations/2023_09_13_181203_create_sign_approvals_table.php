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
        Schema::create('sign_approvals', function (Blueprint $table) {
            $table->id();
            $table->string('module');
            $table->string('module_icon')->nullable();
            $table->string('subject');
            $table->string('document_route_name');
            $table->string('document_route_params')->nullable();
            $table->foreignId('approver_ou_id')->nullable()->constrained('organizational_units');
            $table->foreignId('approver_id')->nullable()->constrained('users');
            $table->datetime('approver_at')->nullable();
            $table->boolean('status')->nullable();
            $table->string('reject_observation')->nullable();
            $table->string('callback_controller_method')->nullable();
            $table->string('callback_controller_params')->nullable();
            $table->boolean('digital_signature')->default(0);
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
        Schema::dropIfExists('sign_approvals');
    }
};
