<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('number',50)->nullable();
            $table->integer('internal_number')->nullable();
            $table->date('date')->nullable();
            $table->foreignId('type_id')->nullable()->constrained('doc_types');
            $table->boolean('reserved')->nullable();
            $table->text('antecedent')->nullable();
            $table->text('responsible')->nullable();
            $table->string('subject')->nullable();
            $table->string('from')->nullable();
            $table->string('for')->nullable();
            $table->enum('greater_hierarchy',['from','for']);
            $table->text('distribution')->nullable();
            $table->longtext('content');
            $table->string('file')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('organizational_unit_id')->constrained('organizational_units');
            $table->foreignId('file_to_sign_id')->nullable()->constrained('doc_signatures_files');
            $table->foreignId('establishment_id')->nullable()->constrained('establishments');
            $table->foreignId('signature_id')->nullable()->constrained('sign_signatures');
           
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
        Schema::dropIfExists('documents');
    }
}
