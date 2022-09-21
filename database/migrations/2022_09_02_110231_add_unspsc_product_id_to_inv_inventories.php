<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnspscProductIdToInvInventories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inv_inventories', function (Blueprint $table) {
            $table->foreignId('unspsc_product_id')
                ->after('product_id')
                ->nullable()
                ->constrained('unspsc_products');

            $table->foreignId('user_using_id')
                ->after('user_responsible_id')
                ->nullable()
                ->constrained('users');

            $table->string('description', 255)
                ->nullable()
                ->after('deliver_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
