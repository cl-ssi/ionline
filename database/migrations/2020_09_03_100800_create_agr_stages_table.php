<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgrStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agr_stages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type',
                ['Enc. Convenio','Jefe APS','Jurídico','Finanzas','Envío Comuna','Devuelto Comuna','RTP','DAJ','DAP','DGF','SDGA','Comuna','OfParte']);
            $table->enum('group',
                ['CON','RES']);
            $table->date('date'); 
            $table->date('dateEnd')->nullable();

            //ADENDUM DATE
            $table->date('date_addendum')->nullable();
            $table->date('dateEnd_addendum')->nullable();

            $table->string('observation')->nullable();
            $table->string('file')->nullable();
            $table->unsignedBigInteger('agreement_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('agreement_id')->references('id')->on('agr_agreements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agr_stages');
    }
}
