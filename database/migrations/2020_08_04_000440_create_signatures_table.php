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
        Schema::create('doc_signatures', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->foreignId('ou_id')->constrained('organizational_units');
            $table->foreignId('responsable_id')->constrained('users');
            $table->datetime('request_date');
            $table->foreignId('type_id')->nullable()->constrained('doc_types');
            $table->boolean('reserved')->nullable();
            $table->string('subject', 255)->nullable(); //honorarios, covid19, etc.
            $table->string('description', 255)->nullable();
            $table->string('url')->nullable();
            $table->string('endorse_type', 255)->nullable(); //tipo de visación
            $table->text('recipients')->nullable(); //destinatarios
            $table->text('distribution')->nullable(); //distribución
            $table->foreignId('user_id')->constrained('users');
            $table->string('verification_code')->nullable(); /* ej: afo2f42o2f */
            $table->boolean('visatorAsSignature')->nullable();
            $table->dateTime('rejected_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('doc_signatures_files', function (Blueprint $table) {
            $table->id();
            $table->binary('file')->nullable();
            $table->string('md5_file')->nullable();
            $table->enum('file_type', ['documento', 'anexo'])->nullable();
            $table->binary('signed_file')->nullable();
            $table->string('md5_signed_file')->nullable();
            $table->foreignId('signature_id')->nullable()->constrained('doc_signatures');
            $table->foreignId('signer_id')->nullable()->constrained('users');
            $table->string('verification_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // DB::statement("ALTER TABLE doc_signatures_files MODIFY COLUMN file MEDIUMBLOB");
        // DB::statement("ALTER TABLE doc_signatures_files MODIFY COLUMN signed_file MEDIUMBLOB");

        Schema::create('doc_signatures_flows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('signatures_file_id')->constrained('doc_signatures_files');
            $table->enum('type', ['visador', 'firmante'])->nullable();
            $table->foreignId('ou_id')->constrained('organizational_units');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('real_signer_id')->nullable()->constrained('users');
            $table->tinyInteger('sign_position')->nullable(); //sólo para type Visador
            $table->boolean('status')->nullable(); // Signed 1 Unsigned 0
            $table->datetime('signature_date')->nullable();
            $table->longText('observation')->nullable();
            $table->integer('custom_x_axis')->nullable();
            $table->integer('custom_y_axis')->nullable();
            $table->enum('visator_type', ['elaborador', 'revisador', 'aprobador'])->nullable();
            $table->integer('position_visator_type')->nullable();

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
        Schema::dropIfExists('doc_signatures_flows');
        Schema::dropIfExists('doc_signatures_files');
        Schema::dropIfExists('doc_signatures');
    }
};
