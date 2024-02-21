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
        Schema::create('frm_inventory_adjustment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        // Schema::table('frm_dispatches', function (Blueprint $table) {
        //     $table->foreignId('inventory_adjustment_type_id')->after('notes')->nullable()->constrained('frm_inventory_adjustment_types');
        //     $table->boolean('inventory_adjustment')->after('notes')->default(0);
        // });

        // Schema::table('frm_receivings', function (Blueprint $table) {
        //     $table->foreignId('inventory_adjustment_type_id')->after('notes')->nullable()->constrained('frm_inventory_adjustment_types');
        //     $table->boolean('inventory_adjustment')->after('notes')->default(0);
        // });

        Schema::create('frm_inventory_adjustments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->foreignId('inventory_adjustment_type_id')->constrained('frm_inventory_adjustment_types');
            $table->foreignId('pharmacy_id')->constrained('frm_pharmacies');
            $table->foreignId('user_id')->constrained('users');
            $table->string('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('frm_dispatches', function (Blueprint $table) {
            $table->foreignId('inventory_adjustment_id')->after('notes')->nullable()->constrained('frm_inventory_adjustments');
        });

        Schema::table('frm_receivings', function (Blueprint $table) {
            $table->unsignedBigInteger('establishment_id')->nullable()->change();
            $table->foreignId('inventory_adjustment_id')->after('notes')->nullable()->constrained('frm_inventory_adjustments');
        });

        Schema::table('frm_dispatch_items', function (Blueprint $table) {
            $table->string('barcode')->nullable()->change();('frm_inventory_adjustments');
        });

        Schema::table('frm_purchases_items', function (Blueprint $table) {
            $table->string('barcode')->nullable()->change();('frm_inventory_adjustments');
        });

        Schema::table('frm_receiving_items', function (Blueprint $table) {
            $table->string('barcode')->nullable()->change();('frm_inventory_adjustments');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frm_inventory_adjustment_types');

        Schema::table('frm_dispatches', function (Blueprint $table) {
            $table->dropColumn('inventory_adjustment_type_id');
            $table->dropColumn('inventory_adjustment');
        });
       
        Schema::table('frm_receivings', function (Blueprint $table) {
            $table->dropColumn('inventory_adjustment_type_id');
            $table->dropColumn('inventory_adjustment');
        });
    }
};
