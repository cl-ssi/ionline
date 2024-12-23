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
        Schema::create('users', function (Blueprint $table) {
            /** No se usa id() porque no es autoincremental */
            $table->bigInteger('id')->unsigned()->unique();
            $table->char('dv', 1);
            $table->string('run', 10)->virtualAs('UPPER(CONCAT(CAST(id AS CHAR), TRIM(dv)))');
            $table->string('name');
            $table->string('fathers_family');
            $table->string('mothers_family');
            $table->string('full_name')->virtualAs("CONCAT(name, ' ', fathers_family, ' ', mothers_family)");
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('commune_id')->nullable()->constrained('cl_communes');
            $table->string('phone_number')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->string('email')->nullable();
            $table->string('email_personal')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->datetime('password_changed_at')->nullable();
            $table->string('position')->nullable();
            $table->date('birthday')->nullable();
            $table->string('vc_link')->nullable();
            $table->string('vc_alias')->nullable();
            $table->foreignId('establishment_id')->nullable()->constrained();
            $table->foreignId('organizational_unit_id')->nullable()->constrained('organizational_units');
            $table->boolean('active')->default(true);
            $table->boolean('gravatar')->default(0);
            $table->boolean('absent')->default(false);
            $table->boolean('external')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
