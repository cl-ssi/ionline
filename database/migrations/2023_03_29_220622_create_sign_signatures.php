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
        Schema::create('sign_signatures', function (Blueprint $table) {
            $table->id();

            $table->integer('number')->nullable();
            $table->datetime('document_number')->nullable();
            $table->foreignId('type_id')->nullable()->constrained('doc_types');
            $table->boolean('reserved')->nullable();
            $table->string('subject')->nullable();
            $table->text('description')->nullable();
            $table->string('file')->nullable();

            $table->text('distribution')->nullable();
            $table->text('recipients')->nullable();

            $table->boolean('is_blocked')->default(false);

            $table->string('status')->nullable(); // pending, signed, rejected
            $table->datetime('status_at')->nullable();

            $table->string('verification_code')->nullable();
            $table->string('signed_file')->nullable();
            $table->string('page')->nullable(); // first o last

            $table->boolean('column_left_visator')->nullable();
            $table->string('column_left_endorse')->nullable();

            $table->boolean('column_center_visator')->nullable();
            $table->string('column_center_endorse')->nullable();

            $table->boolean('column_right_visator')->nullable();
            $table->string('column_right_endorse')->nullable();

            $table->foreignId('user_id')->nullable()->constrained('users'); // creado por
            $table->foreignId('ou_id')->nullable()->constrained('organizational_units');

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
        Schema::dropIfExists('sign_signatures');
    }
};
