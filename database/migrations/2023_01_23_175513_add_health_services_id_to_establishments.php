<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddHealthServicesIdToEstablishments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('establishments', function (Blueprint $table) {
            $table->foreignId('health_services_id')->nullable()->after('dependency')->references('id')->on('health_services');
        });

        $establishments = DB::table('establishments')->get();
        foreach($establishments as $establishment) {
            $health_service = DB::table('health_services')->where('name', $establishment->dependency)->first();
            if($health_service) {
                DB::table('establishments')->where('id', $establishment->id)->update(['health_services_id' => $health_service->id]);
            }
        }
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('establishments', function (Blueprint $table) {
            //
            $table->dropConstrainedForeignId('health_services_id');
        });
    }
}
