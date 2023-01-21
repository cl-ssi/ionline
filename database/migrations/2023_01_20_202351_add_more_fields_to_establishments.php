<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFieldsToEstablishments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('establishments', function (Blueprint $table) {
            //
            $table->string('dependency')->nullable()->after('commune_id');
            $table->string('official_name')->nullable()->after('dependency');
            $table->string('administrative_dependency')->nullable()->after('official_name');
            $table->string('level_of_care')->nullable()->after('administrative_dependency');
            $table->string('street_type')->nullable()->after('level_of_care');
            $table->string('street_number')->nullable()->after('street_type');
            $table->string('address')->nullable()->after('street_number');
            $table->string('telephone')->nullable()->after('address');
            $table->string('emergency_service')->nullable()->after('telephone');
            $table->string('latitude')->nullable()->after('emergency_service');
            $table->string('longitude')->nullable()->after('latitude');
            $table->string('provider_type_health_system')->nullable()->after('longitude');
            $table->string('level_of_complexity')->nullable()->after('longitude');
            
            
            
        });
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
            $table->dropColumn('dependency');
            $table->dropColumn('official_name');
            $table->dropColumn('administrative_dependency');
            $table->dropColumn('level_of_care');
            $table->dropColumn('street_type');
            $table->dropColumn('street_number');
            $table->dropColumn('address');
            $table->dropColumn('telephone');
            $table->dropColumn('emergency_service');
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
            $table->dropColumn('provider_type_health_system');
            $table->dropColumn('level_of_complexity');
        });
    }
}
