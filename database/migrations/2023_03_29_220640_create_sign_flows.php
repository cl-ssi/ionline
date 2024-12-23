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
        Schema::create('sign_flows', function (Blueprint $table) {
            $table->id();

            $table->boolean('is_visator'); // 1:Visador 0:Firmante

            $table->string('md5_file'); // md5 file
            $table->string('file')->nullable(); // file to signed
            $table->string('column_position'); // left right center
            $table->integer('row_position'); // 0 1 2

            $table->string('status')->nullable(); // pending, signed, rejected
            $table->datetime('status_at')->nullable();
            $table->text('rejected_observation')->nullable();

            $table->foreignId('signer_id')->nullable()->constrained('users'); // firmante
            $table->foreignId('original_signer_id')->nullable()->constrained('users');

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
        Schema::dropIfExists('sign_flows');
    }
};
