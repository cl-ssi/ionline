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
            $table->bigIncrements('id');
            $table->integer('number')->nullable();
            $table->date('date')->nullable();
            $table->enum('type',['Memo','Ordinario','Reservado','Circular','Acta de recepción','Otros']);
            $table->text('antecedent')->nullable();
            $table->text('responsible')->nullable();
            $table->string('subject');
            $table->string('from');
            $table->string('for');
            $table->enum('greater_hierarchy',['from','for']);
            $table->text('distribution');
            $table->longtext('content');
            $table->string('file')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('organizational_unit_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('organizational_unit_id')->references('id')->on('organizational_units');
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
