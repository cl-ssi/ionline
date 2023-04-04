<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignSignatures extends Migration
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

            $table->datetime('document_number')->nullable(); // editable
            $table->foreignId('type_id')->nullable()->constrained('doc_types'); // Tipo de Documento
            $table->boolean('reserved')->nullable();
            $table->string('subject')->nullable();
            $table->text('description')->nullable();
            $table->string('file')->nullable(); //

            $table->text('distribution')->nullable();
            $table->text('recipients')->nullable();

            $table->string('status')->nullable(); // pending, signed, rejected
            $table->datetime('status_at')->nullable();

            $table->string('verification_code')->nullable();
            $table->string('signed_file')->nullable();
            $table->string('page')->nullable(); // first o last

            $table->boolean('column_left_visator')->nullable(); // isVisator
            $table->string('column_left_endorse')->nullable(); // tipo de Visacion

            $table->boolean('column_center_visator')->nullable(); // isVisator
            $table->string('column_center_endorse')->nullable(); // tipo de Visacion

            $table->boolean('column_right_visator')->nullable(); // isVisator
            $table->string('column_right_endorse')->nullable(); // tipo de Visacion

            $table->foreignId('user_id')->nullable()->constrained('users'); // Creado por
            $table->foreignId('ou_id')->nullable()->constrained('organizational_units'); // Unidad Organizational del UserId

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
}
