<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeNullableFieldsToRstRequestReplacementStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rst_request_replacement_staff', function (Blueprint $table) {
            $table->unsignedBigInteger('profile_manage_id')->nullable()->change();
            $table->dropForeign(['profile_manage_id']);
            $table->foreign('profile_manage_id')->references('id')->on('rst_profile_manages');

            $table->date('start_date')->nullable()->change();
            $table->date('end_date')->nullable()->change();

            $table->unsignedBigInteger('legal_quality_manage_id')->nullable()->change();
            $table->dropForeign(['legal_quality_manage_id']);
            $table->foreign('legal_quality_manage_id')->references('id')->on('rst_legal_quality_manages');
            
            $table->unsignedBigInteger('fundament_manage_id')->nullable()->change();
            $table->dropForeign(['fundament_manage_id']);
            $table->foreign('fundament_manage_id')->references('id')->on('rst_fundament_manages');
            
            $table->unsignedBigInteger('fundament_detail_manage_id')->nullable()->change();
            $table->dropForeign(['fundament_detail_manage_id']);
            $table->foreign('fundament_detail_manage_id')->references('id')->on('rst_fundament_detail_manages');

            DB::statement("ALTER TABLE rst_request_replacement_staff MODIFY work_day ENUM('diurnal','third shift','fourth shift','other') DEFAULT NULL");
            DB::statement("ALTER TABLE rst_request_replacement_staff MODIFY request_status ENUM('pending','complete','rejected') DEFAULT NULL");

            $table->integer('charges_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rst_request_replacement_staff', function (Blueprint $table) {
            $table->unsignedBigInteger('profile_manage_id')->nullable(false)->change();
            $table->dropForeign(['profile_manage_id']);
            $table->foreign('profile_manage_id')->references('id')->on('rst_profile_manages');

            $table->date('start_date')->nullable(false)->change();
            $table->date('end_date')->nullable(false)->change();

            $table->unsignedBigInteger('legal_quality_manage_id')->nullable(false)->change();
            $table->dropForeign(['legal_quality_manage_id']);
            $table->foreign('legal_quality_manage_id')->references('id')->on('rst_legal_quality_manages');
            
            $table->unsignedBigInteger('fundament_manage_id')->nullable(false)->change();
            $table->dropForeign(['fundament_manage_id']);
            $table->foreign('fundament_manage_id')->references('id')->on('rst_fundament_manages');

            $table->unsignedBigInteger('fundament_detail_manage_id')->nullable(false)->change();
            $table->dropForeign(['fundament_detail_manage_id']);
            $table->foreign('fundament_detail_manage_id')->references('id')->on('rst_fundament_detail_manages');

            DB::statement("ALTER TABLE rst_request_replacement_staff MODIFY work_day ENUM('diurnal','third shift','fourth shift','other') NOT NULL");
            DB::statement("ALTER TABLE rst_request_replacement_staff MODIFY request_status ENUM('pending','complete','rejected') NOT NULL");
        });
    }
}
