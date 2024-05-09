<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            /** Es equivalente a $table->id() de laravel 8 */
            $table->bigInteger('id')->unsigned()->unique();
            $table->char('dv',1);
            $table->string('name');
            $table->string('fathers_family');
            $table->string('mothers_family');
            $table->string('email');
            $table->string('email_personal')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('position')->nullable();
            $table->date('birthday')->nullable();
            $table->foreignId('organizational_unit_id')->nullable()->constrained('organizational_units');
            $table->boolean('active')->default(true);
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
}
