<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Finance\Receptions\ReceptionType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fin_reception_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('establishment_id')->constrained('establishments');
            $table->timestamps();
        });

        ReceptionType::create([
            'name' => 'Bienes',
            'establishment_id' => 38,
        ]);
        ReceptionType::create([
            'name' => 'Servicios',
            'establishment_id' => 38,
        ]);
        ReceptionType::create([
            'name' => 'Obras',
            'establishment_id' => 38,
        ]);


        ReceptionType::create([
            'name' => 'Bienes',
            'establishment_id' => 41,
        ]);
        ReceptionType::create([
            'name' => 'Servicios',
            'establishment_id' => 41,
        ]);
        ReceptionType::create([
            'name' => 'Obras',
            'establishment_id' => 41,
        ]);


        ReceptionType::create([
            'name' => 'Bienes',
            'establishment_id' => 1,
        ]);
        ReceptionType::create([
            'name' => 'Servicios',
            'establishment_id' => 1,
        ]);
        ReceptionType::create([
            'name' => 'Obras',
            'establishment_id' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fin_reception_types');
    }
};
