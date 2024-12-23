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
        Schema::create('establishments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias')->nullable();
            $table->enum('type', ['HOSPITAL', 'CESFAM', 'CECOSF', 'PSR', 'CGR', 'SAPU', 'COSAM', 'PRAIS']);
            $table->foreignId('establishment_type_id')->nullable()->constrained('establishment_types');
            $table->string('deis')->nullable();
            $table->integer('new_deis')->nullable();
            $table->string('mother_code')->nullable();
            $table->integer('new_mother_code')->nullable();
            $table->integer('sirh_code')->nullable();
            $table->foreignId('commune_id')->constrained('communes');
            $table->string('dependency')->nullable();
            $table->foreignId('health_service_id')->nullable()->constrained('health_services');
            $table->string('official_name')->nullable();
            $table->string('administrative_dependency')->nullable();
            $table->string('level_of_care')->nullable();
            $table->string('street_type')->nullable();
            $table->string('street_number')->nullable();
            $table->string('address')->nullable();
            $table->string('url')->nullable();
            $table->string('telephone')->nullable();
            $table->string('emergency_service')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('level_of_complexity')->nullable();
            $table->string('provider_type_health_system')->nullable();
            $table->string('mail_director')->nullable();
            //Una migracion aparte por que depende de Organizational Units que aun no ha sido creada
            //$table->foreignId('father_organizational_unit_id')->nullable()->constrained('organizational_units');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('establishments');
    }
};
