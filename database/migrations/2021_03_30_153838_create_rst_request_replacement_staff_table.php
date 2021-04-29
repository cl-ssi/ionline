<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRstRequestReplacementStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rst_request_replacement_staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('degree')->nullable();
            $table->enum('legal_quality',['to hire', 'fee']);
            $table->enum('work_day',['diurnal', 'third shift', 'fourth shift', 'other']);
            $table->string('other_work_day')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('fundament',['replacement',
                                      'quit',
                                      'allowance without payment',
                                      'regularization work position',
                                      'expand work position',
                                      'vacations',
                                      'other']);
            $table->string('other_fundament')->nullable();
            $table->string('name_to_replace')->nullable();
            $table->string('budget_item')->nullable();
            $table->string('budgetary_provision')->nullable();

            $table->foreignId('user_id');
            $table->foreignId('organizational_unit_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('organizational_unit_id')->references('id')->on('organizational_units');

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
        Schema::dropIfExists('rst_request_replacement_staff');
    }
}
