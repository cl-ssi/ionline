<?php

use App\Models\Cfg\Program as CfgProgram;
use App\Pharmacies\Program;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCfgPrograms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cfg_programs', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255)->nullable();
            $table->text('description', 255)->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        $pharmacyPrograms = Program::all();

        foreach($pharmacyPrograms as $program)
        {
            CfgProgram::create([
                'name' => $program->name,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cfg_programs');
    }
}
