<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Parameters\Estament;

class CreateEstamentsTable extends Migration
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
            $table->string('category',1);
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Estament::create([
            'category' => 'A', 
            'name' => 'Médicos/Químico Farmacéuticos/Odontólogos'
        ]);
        Estament::create([
            'category' => 'B', 
            'name' => 'Otros profesionales'
        ]);
        Estament::create([
            'category' => 'C', 
            'name' => 'Técnicos de nivel superior'
        ]);
        Estament::create([
            'category' => 'D', 
            'name' => 'Técnicos de nivel medio'
        ]);
        Estament::create([
            'category' => 'E', 
            'name' => 'Administrativos'
        ]);
        Estament::create([
            'category' => 'F', 
            'name' => 'Choferes/Serenos'
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
}
