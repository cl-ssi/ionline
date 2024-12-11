<?php

use App\Models\Parameters\Subtitle;
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
        Schema::create('cfg_subtitles', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('name')->unsigned();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Subtitle::create(['name' => '21']);
        Subtitle::create(['name' => '22']);
        Subtitle::create(['name' => '24']);
        Subtitle::create(['name' => '29']);
        Subtitle::create(['name' => '31']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cfg_subtitles');
    }
};
