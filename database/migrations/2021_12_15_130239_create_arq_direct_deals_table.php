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
        Schema::create('arq_direct_deals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_type_id')->nullable()->constrained('cfg_purchase_types'); //8 = TRATO DIRECTO MAYOR A 30 Y MENOR A 1.000 UTMphp
            $table->string('description')->nullable();
            $table->boolean('is_lower_amount')->nullable();
            $table->string('resol_direct_deal')->nullable();
            $table->string('resol_contract')->nullable();
            $table->string('guarantee_ticket')->nullable();
            $table->date('guarantee_ticket_exp_date')->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained('cfg_suppliers');
            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arq_direct_deals');
    }
};
