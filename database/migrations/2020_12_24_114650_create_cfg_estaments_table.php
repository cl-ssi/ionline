<?php

use App\Models\Parameters\Estament;
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
        Schema::create('cfg_estaments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Estament::create([
            'name' => 'Administrativo',
        ]);
        Estament::create([
            'name' => 'Auxiliar',
        ]);
        Estament::create([
            'name' => 'Profesional',
        ]);
        Estament::create([
            'name' => 'Técnico',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cfg_estaments');
    }
};
