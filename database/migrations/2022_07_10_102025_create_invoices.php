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
        Schema::create('arq_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number', 255)->unique()->nullable();
            $table->date('date')->nullable();
            $table->decimal('amount')->nullable();
            $table->text('url')->nullable();
            $table->foreignId('control_id')->nullable()->constrained('wre_controls');
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
        Schema::dropIfExists('arq_invoices');
    }
};
