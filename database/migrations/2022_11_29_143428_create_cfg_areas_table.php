<?php

use App\Models\Parameters\Area;
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
        Schema::create('cfg_areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Area::create([
            'name' => 'Administrativo',
        ]);
        Area::create([
            'name' => 'Asistencial',
        ]);
        Area::create([
            'name' => 'Directivo',
        ]);
        Area::create([
            'name' => 'Gestión',
        ]);
        Area::create([
            'name' => 'Operaciones',
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cfg_areas');
    }
};
