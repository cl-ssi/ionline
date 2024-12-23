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
        Schema::create('sign_annexes', function (Blueprint $table) {
            $table->id();

            $table->string('type')->nullable(); // File or URL

            $table->string('url')->nullable();
            $table->string('file')->nullable();

            $table->foreignId('signature_id')->nullable()->constrained('sign_signatures');

            $table->softDeletes();
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
        Schema::dropIfExists('sign_annexes');
    }
};
