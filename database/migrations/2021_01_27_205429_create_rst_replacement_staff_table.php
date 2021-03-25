<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRstReplacementStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rst_replacement_staff', function (Blueprint $table) {
            $table->id();
            //Form
            $table->unsignedInteger('run')->unique();
            $table->char('dv',1);
            //$table->string('other_identification')->nullable();
            $table->date('birthday')->nullable();
            $table->string('name');
            $table->string('fathers_family');
            $table->string('mothers_family');
            $table->enum('gender',['male', 'female', 'other', 'unknown']);
            $table->string('email');
            $table->string('telephone')->nullable();
            $table->string('telephone2')->nullable();
            //$table->string('job_title');
            $table->string('commune');
            $table->string('address');
            $table->text('observations')->nullable();
            $table->string('cv_file')->nullable();

            $table->string('status')->nullable();

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
        Schema::dropIfExists('rst_replacement_staff');
    }
}
