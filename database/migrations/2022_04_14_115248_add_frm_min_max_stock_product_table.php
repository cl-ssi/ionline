<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFrmMinMaxStockProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('frm_products', function (Blueprint $table) {
        $table->string('min_stock')->after('critic_stock')->nullable();
        $table->string('max_stock')->after('min_stock')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('frm_products', function (Blueprint $table) {
          $table->dropColumn(['min_stock','max_stock']);
      });
    }
}
