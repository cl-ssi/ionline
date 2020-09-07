<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocCorrelativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_correlatives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('year');
            $table->enum('type',['Memo','Ordinario','Reservado','Circular',
                                'Acta de recepción','Otros']);
            $table->integer('correlative');
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
        Schema::dropIfExists('doc_correlatives');
    }
}
