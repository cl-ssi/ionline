<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\ProfAgenda\ActivityType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prof_agenda_activity_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('reservable')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        ActivityType::create([
            'name' => 'Reunión de Equipo ust',
            'reservable' => 0
        ]);

        ActivityType::create([
            'name' => '	Inspección',
            'reservable' => 1
        ]);

        ActivityType::create([
            'name' => '	Empa',
            'reservable' => 1
        ]);

        ActivityType::create([
            'name' => '	Pap',
            'reservable' => 1
        ]);

        ActivityType::create([
            'name' => '	Control',
            'reservable' => 1
        ]);

        ActivityType::create([
            'name' => '	Revisión de exámenes',
            'reservable' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prof_agenda_activity_types');
    }
};
